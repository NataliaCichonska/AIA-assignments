# Generated by Django 4.2.1 on 2023-05-26 10:02

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('userview', '0003_rename_text_comment_comment_comment_timestamp'),
    ]

    operations = [
        migrations.CreateModel(
            name='Image',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(default=None, max_length=50)),
                ('img', models.ImageField(default=None, upload_to='images/')),
            ],
        ),
        migrations.AddField(
            model_name='movie',
            name='description',
            field=models.CharField(max_length=1000, null=True),
        ),
        migrations.AddField(
            model_name='movie',
            name='director',
            field=models.CharField(max_length=500, null=True),
        ),
        migrations.AddField(
            model_name='movie',
            name='imdbLink',
            field=models.CharField(max_length=1000, null=True),
        ),
        migrations.AddField(
            model_name='movie',
            name='year',
            field=models.IntegerField(null=True),
        ),
        migrations.AddField(
            model_name='movie',
            name='image',
            field=models.ForeignKey(null=True, on_delete=django.db.models.deletion.CASCADE, to='userview.image'),
        ),
    ]