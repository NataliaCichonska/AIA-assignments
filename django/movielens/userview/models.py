from django.db import models
from django.db import models
from django.conf import settings

class Image(models.Model):
    name = models.CharField(max_length=50, default=None)
    img = models.ImageField(upload_to='images/', default=None)
class Genre(models.Model):
    name = models.CharField(max_length=300)
    def __str__(self):
        return self.name
class Movie(models.Model):
    title = models.CharField(max_length=1000)
    year = models.IntegerField(null=True)
    director = models.CharField(max_length=500, null=True)
    imdbLink= models.CharField(max_length=1000, null=True)
    description= models.CharField(max_length=1000,null=True)
    genres = models.ManyToManyField(Genre)
    image = models.ForeignKey(Image, on_delete=models.PROTECT, null=True)
class Rating(models.Model):
    value = models.IntegerField()
    movie = models.ForeignKey(Movie, on_delete=models.CASCADE)
    user = models.ForeignKey(settings.AUTH_USER_MODEL,
    on_delete=models.CASCADE)
class Comment(models.Model):
    comment = models.CharField(max_length=1000)
    user = models.ForeignKey(settings.AUTH_USER_MODEL,
    on_delete=models.CASCADE)
    movie = models.ForeignKey(Movie, on_delete=models.CASCADE)
    timestamp = models.DateTimeField(auto_now_add=True)


# Create your models here.
