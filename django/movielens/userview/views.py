from django.shortcuts import render, redirect
from django.http import HttpRequest, HttpResponse
from django.template import loader
from .models import Movie, Genre, Rating
from django.shortcuts import get_object_or_404
from django.contrib.auth import login
from .forms import NewUserForm, RateMovieForm
from django.contrib import messages

# def index(request : HttpRequest):
#     movies = Movie.objects.order_by('-title')
#     template = loader.get_template('userview/index.html')
#     context = {
#     'movies' : movies
#     }
#     return HttpResponse(template.render(context,request))
# def view_movie(request: HttpRequest, movie_id):
#     template=loader.get_template('userview/movie.html')
#     obj=get_object_or_404(Movie, pk=movie_id)
#     print(obj.title)
#     context = {
#     'response' : obj
#     }
#     return HttpResponse(template.render(context,request))
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
    # p=Paginator(Movie,4)
    # print(p.page(1).object_list)
    def get_queryset(self):
        return Movie.objects.order_by('-title')
class MovieView(generic.DetailView):
    model = Movie
    template_name = 'userview/movie.html'
    context_object_name = 'response'
class GenreView(generic.DetailView):
    model = Genre
    template_name = 'userview/genre.html'
    context_object_name = 'response'


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




# Create your views here.