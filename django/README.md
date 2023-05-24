Our goal is to create a movie rating platform with Django and Boostrap framework. The
platform conforms to the MVC template. Our platform will be populated with data from the
Movie-Lens dataset. If you have any problems with Bootstrap consult Bootstrap 5 Tutorial
(w3schools.com).

1. Suggest a data model for your project. We are going to implement the following
functionalities:  
done a. A guest user can search for a specific movie with the following filters:[M]  
done i. Genre,  
done ii. Movie Title,  
done iii. Minimum rating.  
b. A guest viewer can view the details of a movie by clicking on an item in the
search list. Details of a movie contain the following informations:  
ii. Average rating of a movie,  
iii. Cross reference to IMDB,  
iv. Image gallery with one image dedicated as a front image  
v. List of comments to the movie  
e. Logged in users can post a comment under a movie. [N]    
1. Prepare templates for (the templates should extend the layout template):  
done a. the home page - the home page consists of:  
done i. a brief introduction to the portal (you can fill it with lorem)  
done ii. a list the most popular movies (recently)  
done iii. if a logged in user is viewing the home page - a list of  
recommendation (for now, leave it empty) [M] 