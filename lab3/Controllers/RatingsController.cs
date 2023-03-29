using Microsoft.AspNetCore.Mvc;
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
            string RatedMovie = tokens[1];
            string RatingUser = tokens[0];

            Rating r = new Rating();
            r.RatingValue = RatingValue;

            IQueryable < Movie > movieResult = dbContext.Movies.Where(e => e.MovieID == int.Parse(RatedMovie));
            if(movieResult.Count() ==0) {
                continue;
            }
            r.RatedMovie = movieResult.First();

            User user = new User();
            user.UserID=int.Parse(RatingUser);
            user.Name="";
            user=new User();
            r.RatingUser = user;

            if (!dbContext.Ratings.Any(e => e.RatingID == r.RatingID)) dbContext.Ratings.Add(r);

        }
        dbContext.SaveChanges();
        return "OK";
    }

}