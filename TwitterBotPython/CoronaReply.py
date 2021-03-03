import tokens as tk
import requests
from requests_oauthlib import OAuth1 
import PostTweet as pt
import BeautifulSoup as bs
import PicGenerator as pg
import APIlib as api
import ConfigTweets as ct

import json
from time import sleep



#return last 5 replies to specific tweet and follow users that are not already followed.
def reply_on_user(tweet_id):

    mentions = api.return_mentions()
    replies = api.get_my_replies()

    #loop over all the mentions returned.
    for i in range(len(mentions.json())):
        already_replied = False

        comment = mentions.json()[i]

        #check if the mention is a reply to the specified tweet_id(tweet_id)
        if(comment['in_reply_to_status_id'] == int(tweet_id)):
            for j in range(len(replies)):
                if(replies[j]['in_reply_to_status_id'] == comment['id']):
                    # print("Already replied on")
                    already_replied = True
                    break                
                else:
                    continue

            countries = ['usa', 'spain', 'italy', 'uk', 'france', 'germany', 'russia', 'turkey', 'brazil', 'iran', 'canada', 'belgium', 'peru', 'india', 'netherlands', 'ecuador', 'switzerland', 'saudi arabia', 'portugal', 'mexico', 'sweden', 'ireland', 'pakistan', 'chile', 'singapore', 'belarus', 'israel', 'qatar', 'austria', 'japan', 'uae', 'poland', 'romania', 'ukraine', 'indonesia', 's. korea', 'bangladesh', 'denmark', 'serbia', 'philippines', 'dominican republic', 'norway', 'czechia', 'colombia', 'south africa', 'panama', 'australia', 'egypt', 'malaysia', 'finland', 'kuwait', 'morocco', 'argentina', 'algeria', 'moldova', 'kazakhstan', 'luxembourg', 'bahrain', 'hungary', 'thailand', 'afghanistan', 'ghana', 'oman', 'greece', 'nigeria', 'armenia', 'iraq', 'uzbekistan', 'croatia', 'cameroon', 'azerbaijan', 'bosnia and herzegovina', 'iceland', 'guinea', 'estonia', 'cuba', 'bulgaria', 'bolivia', 'north macedonia', 'new zealand', 'slovenia', 'ivory coast', 'lithuania', 'slovakia', 'senegal', 'djibouti', 'honduras', 'hong kong', 'tunisia', 'latvia', 'cyprus', 'kyrgyzstan', 'albania', 'somalia', 'niger', 'sri lanka', 'andorra', 'costa rica', 'lebanon', 'diamond princess', 'guatemala', 'mayotte', 'drc', 'sudan', 'burkina faso', 'uruguay', 'georgia', 'san marino', 'mali', 'el salvador', 'channel islands', 'maldives', 'kenya', 'tanzania', 'malta', 'jamaica', 'jordan', 'taiwan', 'réunion', 'paraguay', 'gabon', 'palestine', 'venezuela', 'mauritius', 'isle of man', 'montenegro', 'equatorial guinea', 'vietnam', 'rwanda', 'guinea-bissau', 'congo', 'tajikistan', 'faeroe islands', 'martinique', 'sierra leone', 'cabo verde', 'liberia', 'myanmar', 'guadeloupe', 'madagascar', 'gibraltar', 'ethiopia', 'brunei', 'zambia', 'french guiana', 'togo', 'cambodia', 'chad', 'trinidad and tobago', 'eswatini', 'bermuda', 'haiti', 'aruba', 'benin', 'monaco', 'uganda', 'car', 'bahamas', 'guyana', 'barbados', 'liechtenstein', 'mozambique', 'sint maarten', 'cayman islands', 'nepal', 'libya', 'french polynesia', 'south sudan', 'macao', 'syria', 'malawi', 'mongolia', 'eritrea', 'saint martin', 'angola', 'zimbabwe', 'antigua and barbuda', 'timor-leste', 'sao tome and principe', 'botswana', 'grenada', 'laos', 'belize', 'fiji', 'new caledonia', 'saint lucia', 'gambia', 'st. vincent grenadines', 'curaçao', 'dominica', 'namibia', 'nicaragua', 'burundi', 'saint kitts and nevis', 'falkland islands', 'yemen', 'turks and caicos', 'montserrat', 'greenland', 'vatican city', 'seychelles', 'suriname', 'ms zaandam', 'mauritania', 'papua new guinea', 'bhutan', 'british virgin islands', 'caribbean netherlands', 'st. barth', 'western sahara', 'anguilla']


            
            #if given comment has not been replied on yet. 
            if(not already_replied):
                print("the comment of user is : ",comment['text'])
                print(len(comment['entities']['hashtags']))
                if(len(comment['entities']['hashtags']) > 0):
                    reply_on_user_hashtag(comment)
                else:
                    text = comment['text']
                    x = text.replace('@cmpsbot ','').lower()
                    username = comment['user']['screen_name']
                    if(x in countries):
                        bs.reply_stat(x,comment['id'],username)
                        sleep(2)

            #check if we are already following the user replying or not
            if(not comment['user']['following']):
                #call follow_back
                api.follow_back(comment['user']['screen_name'])

        else:
            if(len(comment['entities']['hashtags']) > 0):
                reply_on_user_hashtag(comment)


def post_stat():
    pg.generate_picture()
    pt.post_pic()

"""
reply on a specific user based on the hashtag he wrote 
(i.e: -#Covid-19 -> reply with statiscs about given country 
      -#tweetOftheDay -> like all comments related to this hashtag. (may include AI response model based on text later on))
"""
def reply_on_user_hashtag(comment):
    hashtag = ct.hashtag_of_the_day()

    print("hashtag of the day: ",hashtag)
    username = comment['user']['screen_name']
    hashtags = comment['entities']['hashtags']

    if(len(hashtags) > 0):
        for i in range(len(hashtags)):
            if(hashtags[i]['text'] == hashtag):
                print("the hashtag given is :",hashtags[i])
                random_reply = ct.reply_to_hashtag()
                pt.reply_to(random_reply,comment['id'],username)
                sleep(2)
        