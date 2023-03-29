using Microsoft.AspNetCore.Mvc;
using System.Globalization;
namespace lab3.Controllers;
[ApiController]
[Route("[controller]")]
public class RatingsController: ControllerBase {

    [HttpPost("UploadRatingsCsv")]
    public string PostRatings(IFormFile inputFile) {
        var strm = inputFile.OpenReadStream();
        byte[] buffer = new byte[inputFile.Length];
        strm.Read(buffer, 0, (int) inputFile.Length);
        string fileContent = System.Text.Encoding.Default.GetString(buffer);
        strm.Close();
        MoviesContext dbContext = new MoviesContext();
        bool skip_header = true;
        foreach(string line in fileContent.Split('\n')) {
            if (skip_header) {
                skip_header = false;
                continue;
            }
            var tokens = line.Split(",");
            if (tokens.Length < 2) continue;
            string RatingValue = tokens[2];
            string RatedMovieID = tokens[1];
            string RatingUserId = tokens[0];

            Rating r = new Rating();
            int res=0;
            r.RatingValue=float.Parse(RatingValue, CultureInfo.InvariantCulture.NumberFormat);
            int.TryParse(RatingValue,out res);

            IQueryable < Movie > movieResult = dbContext.Movies.Where(e => e.MovieID == int.Parse(RatedMovieID));
            System.Console.Write(movieResult.Count());
            System.Console.Write("\n");
            
            if(movieResult.Count() ==0) {
                continue;
            }
            System.Console.Write(movieResult.First().MovieID);
            System.Console.Write("\n");
            r.RatedMovie = movieResult.First();

            User user = new User();
            user.UserID = int.Parse(RatingUserId);
            user.Name="";
            IQueryable < User > userResults = dbContext.Users.Where(e => e.UserID == user.UserID);
                if (userResults.Count() > 0) {
                    user = userResults.First();
                }
                else {
                    dbContext.Users.Add(user);
                    dbContext.SaveChanges();
                }
            r.RatingUser = user;
            user=new User();

            dbContext.Ratings.Add(r);

        }
        dbContext.SaveChanges();
        return "OK";
    }

//w sortedRatingsList Mvie i User są zawsze null...
    [HttpGet("GetUserRecommendations/{userId}")]
    public IEnumerable<Movie> GetUserRecommendations(int userId) {
        System.Console.Write("wchodzę");
        MoviesContext dbContext = new MoviesContext();
        IEnumerable <Rating> usersRatings = dbContext.Ratings.Where(
            r => r.RatingUser.UserID == userId
        );
        List < Movie > ratedMovies = new List < Movie > ();
        usersRatings.ToList();
        List<Rating> SortedRatingsList = usersRatings.ToList().OrderBy(o=>o.RatingValue).ToList();
        foreach(Rating rating in SortedRatingsList){
            System.Console.Write(rating.RatingID);
        }
            
        
        return ratedMovies; 
        }
}

