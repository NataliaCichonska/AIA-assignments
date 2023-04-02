using Microsoft.EntityFrameworkCore;
using Microsoft.AspNetCore.Mvc;
namespace lab3.Controllers;
[ApiController]
[Route("[controller]")]
public class RatingsController : ControllerBase
{

    [HttpPost("UploadRatingCsv")]
    public string Post(IFormFile inputFile)
    {
        var strm = inputFile.OpenReadStream();
        byte[] buffer = new byte[inputFile.Length];
        strm.Read(buffer, 0, (int)inputFile.Length);
        string fileContent = System.Text.Encoding.Default.GetString(buffer);
        strm.Close();
        MoviesContext dbContext = new MoviesContext();
        bool skip_header = true;
        int i = 0;
        foreach (string line in fileContent.Split('\n'))
        {
            if (skip_header)
            {
                skip_header = false;
                continue;
            }
            i++;
            var tokens = line.Split(",");
            if (tokens.Length != 4) continue;
            string UserID = tokens[0];
            string MovieID = tokens[1];
            string RatingValue = tokens[2];
            string timestamp = tokens[3];
            User u = new User();
            u.UserID = int.Parse(UserID);
            if (!dbContext.Users.Any(e => e.UserID == u.UserID))
            {
                u.Name = UserID;
                dbContext.Users.Add(u);
                dbContext.SaveChanges();
            }
            IQueryable<User> userResults = dbContext.Users.Where(e => e.UserID == u.UserID);
            Movie m = new Movie();
            m.MovieID = int.Parse(MovieID);
            if (!dbContext.Movies.Any(e => e.MovieID == m.MovieID))
            {
                m.Title = MovieID;
                dbContext.Movies.Add(m);
                dbContext.SaveChanges();
            }
            IQueryable<Movie> movieResults = dbContext.Movies.Where(e => e.MovieID == m.MovieID);

            Rating r = new Rating();
            r.RatingUser = userResults.First();
            r.RatedMovie = movieResults.First();
            r.RatingValue = int.Parse(RatingValue.Split('.')[0]);
            r.RatingID = i;

            if (!dbContext.Ratings.Any(e => e.RatingID == r.RatingID)) dbContext.Ratings.Add(r);
        }
        dbContext.SaveChanges();
        return "OK";
    }

    [HttpGet("GetUserRatings/{userId}")]
    public IEnumerable<Rating> GetUserRatings(int userId)
    {
        MoviesContext dbContext = new MoviesContext();
        IEnumerable<Rating> usersRatings = dbContext.Ratings.Include(r => r.RatedMovie).Where(
            r => r.RatingUser.UserID == userId
        );
        return usersRatings;
    }

    [HttpGet("GetSortedUserRatings/{userId}")]
    public IEnumerable<Rating> GetSortedUserRatings(int userId)
    {

        return GetUserRatings(userId).OrderByDescending(r => r.RatingValue);
    }
}

