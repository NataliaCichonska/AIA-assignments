from django.shortcuts import render, redirect
from django.http import HttpRequest, HttpResponse
from django.template import loader
from .models import Movie, Genre, Rating, Comment
from django.shortcuts import get_object_or_404
from django.contrib.auth import login
from .forms import NewUserForm, RateMovieForm, CommentForm
from django.contrib import messages
from django.db.models import Avg

# def index(request : HttpRequest):
#     movies = Movie.objects.order_by('-title')
#     template = loader.get_template('userview/index.html')
#     context = {
#     'movies' : movies
#     }
#     return HttpResponse(template.render(context,request))


def view_movie(request: HttpRequest, movie_id):
    template=loader.get_template('userview/movie.html')
    movie=get_object_or_404(Movie, pk=movie_id)
    ratings=Rating.objects.filter(movie=movie_id)
    comments=Comment.objects.filter(movie=movie_id)
    sum=0
    for rating in ratings:
        sum+=rating.value
    avarage = sum/len(ratings)
    context = {
    'response' : movie,
    'avarage_rating': avarage,
    'comments': comments
    }
    return HttpResponse(template.render(context,request))


# def view_genre(request: HttpRequest, genre_id):
#     template=loader.get_template('userview/genre.html')
#     obj = get_object_or_404(Genre,pk=genre_id)
#     context = {
#     'response' : obj
#     }
#     return HttpResponse(template.render(context,request))

from django.views import generic
from django.core.paginator import Paginator
class IndexView(generic.ListView):
    template_name = 'userview/index.html'
    context_object_name = 'movies'
    paginate_by=7
    def get_queryset(self):
        movies =  Movie.objects.annotate(average_rating=Avg('rating__value'))
        movies = movies.order_by('-average_rating')
        return movies[:3]
# class MovieView(generic.DetailView):
#     model = Movie
#     template_name = 'userview/movie.html'
#     context_object_name = 'response'
#     def get_context_data(self, **kwargs):
#         pk = kwargs.get('pk') # this is the primary key from your URL
#         print(pk,"-----------------")
#     # your other code
#         context = super(MovieView, self).get_context_data(**kwargs)
#         context['ratings'] = Rating.objects.filter(movie=pk)
#         return context


class GenreView(generic.DetailView):
    model = Genre
    template_name = 'userview/genre.html'
    context_object_name = 'response'

class SearchView(generic.ListView):
    template_name = 'userview/search.html'
    context_object_name = 'movies'
    paginate_by = 7

    def get_queryset(self):
        queryset = Movie.objects.order_by('-title').annotate(average_rating=Avg('rating__value'))

        genre_filter = self.request.GET.get('genre')
        title_filter = self.request.GET.get('title')
        rating_filter = self.request.GET.get('rating')

        if title_filter:
            queryset = queryset.filter(title__icontains=title_filter)

        if genre_filter:
            queryset = queryset.filter(genres__name__icontains=genre_filter)

        if rating_filter:
            queryset = queryset.filter(average_rating__gte=rating_filter)
        return queryset

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['genres'] = Genre.objects.order_by('-name')
        return context

def rated_request(request):
    if request.method == "GET":
        if request.user.is_authenticated:
            ratings = Rating.objects.order_by('-value').filter(user=request.user.id)
            return render (request=request, template_name="userview/ratedMovies.html", context={"ratings":ratings})
        else:
            return redirect("index") 
    else:
        return redirect("index")


def register_request(request):
    if request.method == "POST":
        form = NewUserForm(request.POST)
        if form.is_valid():
            user = form.save()
            login(request, user)
            messages.success(request, "Registration successful." )
            return redirect("index")
        else:
            messages.error(request, "Unsuccessful registration. Invalid information.")
    form = NewUserForm()
    return render (request=request, template_name="userview/register.html", context={"register_form":form})

def rate_request(request):
    if request.user.is_authenticated:
        if request.method == 'POST':
            form = RateMovieForm(request.POST)
            if form.is_valid():
                user=request.user
                rating=form.save()
                rating.user = user
                rating.save()
                messages.success(request, "Rating successful." )
                return redirect("/rated")
            else:
                messages.error(request, "Unsuccessful rating. Something went wrong")
        form = RateMovieForm()
        context = {'form': form}
        return render (request=request, template_name="userview/rate.html", context={"rate_form":form})
    else:
        return redirect("index")

def comment_request(request,movie_id):
    if request.user.is_authenticated:
        if request.method == 'POST':
            form = CommentForm(request.POST)
            if form.is_valid():
                user=request.user
                comment=form.save()
                print(comment.comment)
                comment.user = user
                movie = Movie.objects.get(id=movie_id)
                comment.movie = movie
                comment.save()
                messages.success(request, "Comment successful." )
                redirectUrl = "/movie/"+ str(movie_id)
                return redirect(redirectUrl)
            else:
                messages.error(request, "Unsuccessful comment. Something went wrong")
        form = CommentForm()
        context = {'form': form}
        return render (request=request, template_name="userview/comment.html", context={"comment_form":form})
    else:
        return redirect("index")




# Create your views here.
