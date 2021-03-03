import tokens as tk
import requests
from requests_oauthlib import OAuth1 
import urllib
import tweepy


def ptweet(tweet):
    url = "https://api.twitter.com/1.1/statuses/update.json?status=" + tweet
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                    tk.access_token,tk.access_token_secret)
    response = requests.post(url,auth = auth)

    print(response.content)

def reply_to(tweet,status_id,username):
    encoded_user = urllib.parse.quote("@" + username + " " + tweet)
    url = "https://api.twitter.com/1.1/statuses/update.json?status=" + encoded_user + "&in_reply_to_status_id=" + str(status_id)
    print(url)
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                    tk.access_token,tk.access_token_secret)
    response = requests.post(url,auth = auth)

    print(response.content)

def post_pic():

    auth=tweepy.OAuthHandler(tk.consumer_key,tk.consumer_key_secret)
    auth.set_access_token(tk.access_token,tk.access_token_secret)
    api=tweepy.API(auth)

    #Generate text tweet with media (image)
    status = api.update_with_media("stat.png", "Comment your country to check the latest COVID-19 statistics")
