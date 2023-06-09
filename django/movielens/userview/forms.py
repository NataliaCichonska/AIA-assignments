from django.contrib.auth.models import User
from django.contrib.auth.forms import UserCreationForm,AuthenticationForm
from django import forms
from .models import Movie, Genre, Rating, Comment

class NewUserForm(UserCreationForm):
    email = forms.EmailField(required=True)
    class Meta:
        model = User
        fields = ("username", "email", "password1", "password2")
    def save(self, commit=True):
        user = super(NewUserForm, self).save(commit=False)
        user.email = self.cleaned_data['email']
        if commit:
            user.save()
        return user

class UserModelChoiceField(forms.ModelChoiceField):
    def label_from_instance(self, obj):
        return "%s" % (obj.title)

class RateMovieForm(forms.Form):
    rating = forms.IntegerField(
        label = "Rating",
        required = True,
        min_value= 0,
        max_value= 10,
    )
    movie = UserModelChoiceField(queryset=Movie.objects.all(), label="Movie", required=True)
    def save(self, commit=True):
        rating = Rating()
        rating.movie=self.cleaned_data['movie']
        rating.value=self.cleaned_data['rating']
        return rating

class CommentForm(forms.Form):
    comment = forms.CharField(max_length=1000)
    def save(self, commit=True):
        comment = Comment()
        comment.comment=self.cleaned_data['comment']
        return comment

