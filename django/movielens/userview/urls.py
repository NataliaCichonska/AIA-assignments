from django.urls import path
from . import views
from django.contrib.auth import views as auth_views
from django.conf.urls.static import static 
from django.conf import settings

urlpatterns = [
# path("", views.index, name="index"),
# path("genre/<int:genre_id>", views.view_genre, name="index"),
path("movie/<int:movie_id>", views.view_movie, name="index"),
path("", views.IndexView.as_view(), name="index"),
path("rated", views.rated_request, name="rated"),
path("genre/<int:pk>", views.GenreView.as_view(), name="index"),
# path("movie/<int:pk>", views.MovieView.as_view(), name="index"),
path("register", views.register_request, name="register"),
path("rate", views.rate_request, name="rate"),
path("comment/<int:movie_id>", views.comment_request, name="comment"),
path('login/',auth_views.LoginView.as_view(template_name='userview/login.html'),name='login'),
path('logout/',auth_views.LogoutView.as_view(template_name="userview/logout.html"),name='logout'),
path('search/',views.SearchView.as_view(),name='search')
]+ static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)