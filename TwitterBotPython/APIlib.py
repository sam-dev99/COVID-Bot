import tokens as tk
import requests
from requests_oauthlib import OAuth1
from time import sleep



#return all mentions to the authenticated user
def return_mentions():
    url = "https://api.twitter.com/1.1/statuses/mentions_timeline.json?count=15"
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                tk.access_token,tk.access_token_secret)

    response = requests.get(url,auth=auth)

    return response


def get_my_replies():
    replies = []
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                tk.access_token,tk.access_token_secret)
    
    url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=cmpsbot&count=15"
    response = requests.get(url,auth=auth)

    for i in range(len(response.json())):
        if(not response.json()[i]['in_reply_to_status_id_str']):
            # print("skip the main tweet!!")
            continue
        else:
            replies.append(response.json()[i])

    return replies

#follow back a specifc user
def follow_back(account_name):
    url = "https://api.twitter.com/1.1/friendships/create.json?screen_name=" +account_name + "&follow=true"
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                    tk.access_token,tk.access_token_secret)
    response = requests.post(url,auth=auth)


#get all followers and follow back ones that are not followed
def get_followers():
    url = "https://api.twitter.com/1.1/followers/list.json?cursor=-1&screen_name=cmpsbot&skip_status=true&include_user_entities=false"
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                    tk.access_token,tk.access_token_secret)
    response = requests.get(url,auth=auth)

    users = response.json()['users'] 
    
    for i in range(len(users)):
        if(not users[i]['following']):
            follow_back(users[i]['screen_name'])

#get the latest tweet tweeted by our account.
def get_last_tweet():
    count = 5
    auth = OAuth1(tk.consumer_key,tk.consumer_key_secret,
                    tk.access_token,tk.access_token_secret)
    while(True):
        url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=cmpsbot&count=" + str(count)
        statuses = requests.get(url,auth=auth)

        for i in range(len(statuses.json())):
            if(not statuses.json()[i]['in_reply_to_status_id_str']):
                # print("id of tweet: ",response.json()[i]['id_str'])
                # print(response.json()[i])
                return statuses.json()[i]['id_str']

            else:
                # print("this is a reply.")
                # print("id of tweet reply: ",response.json()[i]['id_str'])
                count += 5
        sleep(5)