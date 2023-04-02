using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
namespace lab3.Controllers;
[ApiController]
[Route("[controller]")]
public class MoviesController : ControllerBase
{
    [HttpPost("UploadMovieCsv")]
    public string Post(IFormFile inputFile)
    {
        var strm = inputFile.OpenReadStream();
        byte[] buffer = new byte[inputFile.Length];
        strm.Read(buffer, 0, (int)inputFile.Length);
        string fileContent = System.Text.Encoding.Default.GetString(buffer);
        strm.Close();
        MoviesContext dbContext = new MoviesContext();
        bool skip_header = true;
        foreach (string line in fileContent.Split('\n'))
        {
            if (skip_header)
            {
                skip_header = false;
                continue;
            }
            var tokens = line.Split(",");
            if (tokens.Length != 3) continue;
            string MovieID = tokens[0];
            string MovieName = tokens[1];
            string[] Genres = tokens[2].Split("|");
            List<Genre> movieGenres = new List<Genre>();
            foreach (string genre in Genres)
            {
                Genre g = new Genre();
                g.Name = genre;
                if (!dbContext.Genres.Any(e => e.Name == g.Name))
                {
                    dbContext.Genres.Add(g);
                    dbContext.SaveChanges();
                }
                IQueryable<Genre> results = dbContext.Genres.Where(e => e.Name == g.Name);
                if (results.Count() > 0)
                    movieGenres.Add(results.First());
            }
            Movie m = new Movie();
            m.MovieID = int.Parse(MovieID);
            m.Title = MovieName;
            m.Genres = movieGenres;
            if (!dbContext.Movies.Any(e => e.MovieID == m.MovieID)) dbContext.Movies.Add(m);

        }
        dbContext.SaveChanges();
        return "OK";
    }

    [HttpGet("GetAllGenres")]
    public IEnumerable<Genre> GetAllGenres()
    {
        MoviesContext dbContext = new MoviesContext();
        return dbContext.Genres.AsEnumerable();
    }

    [HttpGet("GetMoviesByName/{search_phrase}")]
    public IEnumerable<Movie> GetMoviesByName(string search_phrase)
    {
        MoviesContext dbContext = new MoviesContext();
        return dbContext.Movies.Where(e => e.Title.Contains(search_phrase));
    }

    [HttpPost("GetMoviesByGenre")]
    public IEnumerable<Movie> GetMoviesByGenre(string search_phrase)
    {
        MoviesContext dbContext = new MoviesContext();
        return dbContext.Movies.Where(
            m => m.Genres.Any(p => p.Name.Contains(search_phrase))
        );
    }

    [HttpGet("GetGenresByMovie/{movieId}")]
    public IEnumerable<Genre> GetGenresByMovie(int movieId)
    {
        MoviesContext dbContext = new MoviesContext();
        return dbContext.Genres.Where(e => e.Movies.Any(e => e.MovieID == movieId));
    }

    [HttpGet("GetGenresVectorByMovie/{movieId}")]
    public List<int> GetGenresVectorByMovie(int movieId)
    {
        MoviesContext dbContext = new MoviesContext();
        IEnumerable<Movie> movies = dbContext.Movies.Include(movie => movie.Genres).Where(m => m.MovieID == movieId);
        if (movies.Count() < 1)
        {
            throw new ArgumentException("invalid movie id");
        }
        Movie movie = movies.First();
        List<int> vector = new List<int>();
        foreach (Genre genre in dbContext.Genres)
        {
            if (movie.Genres.Any(g => g.GenreID == genre.GenreID))
            {
                vector.Add(1);
            }
            else
            {
                vector.Add(0);
            }

        }
        return vector;
    }

    [HttpGet("GetCosineSimilarity/{movieId1}/{movieId2}")]
    public double GetCosineSimilarity(int movieId1, int movieId2)
    {

        List<int> vec1 = GetGenresVectorByMovie(movieId1);
        List<int> vec2 = GetGenresVectorByMovie(movieId2);

        int m1m2 = 0;
        int m12 = 0;
        int m22 = 0;

        for (int i = 0; i < vec1.Count(); i++)
        {
            m1m2 += vec1[i] * vec2[i];
            m12 += vec1[i] * vec1[i];
            m22 += vec2[i] * vec2[i];
        }

        return (m1m2) / (Math.Sqrt(m12) * Math.Sqrt(m22));
    }

    //TODO: niedziała :((
    /*[HttpGet("GetMoviesSharingGenres/{movieId}")]
    public IEnumerable<Movie> GetMoviesSharingGenres(int movieId)
    {
        MoviesContext dbContext = new MoviesContext();

        IEnumerable<Movie> moviesWithId = dbContext.Movies.Include(movie => movie.Genres).Where(m => m.MovieID == movieId);
        if (moviesWithId.Count() < 1)
        {
            throw new ArgumentException("invalid movie id");
        }
        Movie movie = moviesWithId.First();
        //IEnumerable<Movie> resultMovies = dbContext.Movies.Where(m => m.Genres.Any(g=>movie.Genres.Any(genre => g.GenreID == genre.GenreID)));
        return moviesWithId;
    }*/

    [HttpGet("GetSimilarMovies/{movieId}/{treshhold}")]
    public IEnumerable<Movie> GetSimilarMovies(int movieId, double treshhold)
    {
        MoviesContext dbContext = new MoviesContext();
        List<Movie> resultMovies = new List<Movie>();

        foreach (Movie movie in dbContext.Movies)
        {
            double sim = GetCosineSimilarity(movieId, movie.MovieID);
            if (sim >= treshhold)
            {
                resultMovies.Add(movie);
            }
        }
        return resultMovies;
    }

    [HttpGet("GetSimilarMoviesToTopOne/{userId}")]
    public IEnumerable<Movie> GetSimilarMoviesToTopOne(int userId){

        MoviesContext dbContext = new MoviesContext();
        IEnumerable<Rating> usersRatings = dbContext.Ratings.Include(r => r.RatedMovie).Where(
            r => r.RatingUser.UserID == userId
        );
        Movie topMovie = usersRatings.OrderByDescending(r=>r.RatingValue).First().RatedMovie;
        
        return GetSimilarMovies(topMovie.MovieID, 0.9);

    }

}