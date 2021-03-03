import CoronaReply as cr
import ConfigTweets as ct
import DBconnect as dbc
import time
from binascii import Error
import os
from time import sleep
from APIlib import get_last_tweet as get_tweet

def postPic():
    minutes = 0
    # cr.post_stat()
    # sleep(60)
    #listen to new comments on the last tweet for 12 hours
    while(minutes < 43200):
        id = get_tweet()
        cr.reply_on_user(id)
        sleep(30)
        minutes += 1

def ConfigureTweets():
    connection = dbc.dbCon()
    try:
        ct.executeConfig(connection)
    except Error as e:
        dbc.dbClose()


if __name__ == '__main__':
    print("Enter 1 for Applying new configuration\nEnter 2 to launch the twitterBot\nEnter exit to Exit program")
    while(True):
        command = input("enter command: ")
        if(command == "1"):
            ConfigureTweets()
        elif(command == "2"):
            while(True):
                postPic()
        else:
            continue
