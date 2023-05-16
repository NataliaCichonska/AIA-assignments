Our goal is to create a movie rating platform with Django and Boostrap framework. The
platform conforms to the MVC template. Our platform will be populated with data from the
Movie-Lens dataset. If you have any problems with Bootstrap consult Bootstrap 5 Tutorial
(w3schools.com).

1. Suggest a data model for your project. We are going to implement the following
functionalities:
a. A guest user can search for a specific movie with the following filters:
i. Genre,
ii. Movie Title,
iii. Minimum rating.
b. A guest viewer can view the details of a movie by clicking on an item in the
search list. Details of a movie contain the following informations:
ii. Average rating of a movie,
iii. Cross reference to IMDB,
iv. Image gallery with one image dedicated as a front image
v. List of comments to the movie
e. Logged in users can post a comment under a movie.
f. Admin users can edit details of a movie.
g. Admin users can add a new movie.
1. Prepare templates for (the templates should extend the layout template):
a. the home page - the home page consists of:
i. a brief introduction to the portal (you can fill it with lorem)
ii. a list the most popular movies (recently)
iii. if a logged in user is viewing the home page - a list of
recommendation (for now, leave it empty)
b. the movie search page - this web page consists of:
i. A search form for genre, title, rating (use required=False in the form
definition)
ii. list of search results (consider several formats of the list: a table,
continuous list of cards, a list) - one should be able to access a movie
page through the list items
c. the movie page - this web page displays all movie data, including the movie
images, comments, title, average rating, user rating (if logged in); access to
the actions, such as posting a comment (if logged in); editing a movie (if
admin)
d. admin page - this web page is only visible to an administrator user, it contains
a form, which allows an admin to add a new movie.
1. Implement the view functions, forms and add paths to the urls.py.
2. Add hyperlinks to the movie search and homepage to the navigation bar.
That’s it for the 1st part of the assignment.