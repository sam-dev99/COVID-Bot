import PostTweet as pt
import DBconnect as dbc

import time
import random

import urllib


configurations = {}
tweets_count = 0

#reply with the correct hashtag
def hashtag_of_the_day():
    connection = dbc.dbCon()
    cursor = connection.cursor()
    query = "select distinct hashtag from tweet_topic"
    cursor.execute(query)
    hashtag = cursor.fetchall()
    cursor.close()
    for hashtag_tuple in hashtag:
        if(hashtag_tuple[0] != None):
            print("tag2 of the day: ",hashtag_tuple[0])
            return hashtag_tuple[0]
    # return hashtag[0][0]
    

def reply_to_hashtag():
    connection = dbc.dbCon()
    cursor = connection.cursor()
    query = "select tweet from tweet_topic where hashtag != 'NULL' ORDER BY rand() LIMIT 1;"
    cursor.execute(query)
    reply = cursor.fetchall()
    cursor.close()
    print(reply[0][0])

    return reply[0][0]



#get the deployed configuration.
def getConfig(conn):
    cursor = conn.cursor()
    query = "select title,topic,customized,tweetsperconfig,tweetsperhour,random,incremental,decremental from fileconfig where deploy = '1'"
    cursor.execute(query)

    records = cursor.fetchall()
    conn.commit()
    cursor.close()
    configurations = {"title": "", "topic": '', "customized": '', "tweetsperconfig":"",
                        "tweetsperhour": "", "random":"", "incremental": "", "decremental": ""} 
    elements = list(configurations.keys())
    i = 0
    for element in elements:
        configurations[element] = records[0][i]
        i += 1

    return configurations

def customize(conn):
    default_query = "SELECT ID,tweet FROM tweet_topic where priority = "
    configuration = getConfig(conn)
    lst = configuration["customized"].split(",")
    if(len(lst)>3):
        print("Invalid input!")
    else:
        for prio in lst:
            cursor = conn.cursor()
            custm_query = default_query + prio + " and counter_flag != '1' "
            cursor.execute(custm_query)
            custm_priority = cursor.fetchall()

            print(custm_priority)

            while(len(custm_priority)>0):
                configuration = getConfig(conn)
                    
                if(configuration["customized"] != ""):
                    # print(custm_priority[0][1] + "\n")

                    # print(rand_priority[0][1] + "\n")
                    tweet = custm_priority[0][1]

                    encoded_tweet = urllib.parse.quote(tweet)
                    print(encoded_tweet)
                    # pt.ptweet(encoded_tweet)
                    update_flag = "update tweet_topic set counter_flag = 1 where ID = " + str(custm_priority[0][0]) + " "
                    cursor.execute(update_flag)
                    conn.commit()
                    del custm_priority[0]
                    # tweets_count = tweets_count + 1
                    time.sleep(10*configuration["tweetsperhour"])
                else:
                    break
                
def Random(query,conn):
    query = query + " counter_flag != '1' " + " ORDER BY rand()"
    cursor = conn.cursor()
    cursor.execute(query)
    rand_priority = cursor.fetchall()

    while(len(rand_priority)>0):
        configuration = getConfig(conn)


        if(configuration["random"] == 1):
            # print(rand_priority[0][1] + "\n")
            tweet = rand_priority[0][1]

            encoded_tweet = urllib.parse.quote(tweet)
            print(encoded_tweet)
            # pt.ptweet(encoded_tweet)
            update_flag = "update tweet_topic set counter_flag = 1 where ID = " + str(rand_priority[0][0]) + " "
            cursor.execute(update_flag)
            conn.commit()
            del rand_priority[0]
            # tweets_count = tweets_count + 1
            time.sleep(10 * configuration["tweetsperhour"])

        else:
            break

def incremental(query,conn):
    print("incremeneta")
    query = query + " counter_flag != '1' " +  " ORDER BY priority"
    cursor = conn.cursor()
    print(query)
    cursor.execute(query)
    inc_priority = cursor.fetchall()

    

    while(len(inc_priority)>0):
        configuration = getConfig(conn)
        
        if(configuration["incremental"] == 1):
            # print(inc_priority[0][1] + "\n")
            tweet = inc_priority[0][1]

            encoded_tweet = urllib.parse.quote(tweet)
            print(encoded_tweet)
            # pt.ptweet(encoded_tweet)
            # pt.ptweet()
            update_flag = "update tweet_topic set counter_flag = 1 where ID = " + str(inc_priority[0][0]) + " "
            cursor.execute(update_flag)
            conn.commit()
            del inc_priority[0]
            # tweets_count = tweets_count + 1
            time.sleep(10 * configuration["tweetsperhour"])
        else:
            break

def decremental(query,conn):
    print("we are dec")
    query = query + " counter_flag != '1' " +  " ORDER BY priority DESC"
    cursor = conn.cursor()
    cursor.execute(query)
    dec_priority = cursor.fetchall()

    while(len(dec_priority)>0):
        configuration = getConfig(conn)
        
        if(configuration["decremental"] == 1):

            # print(rand_priority[0][1] + "\n")
            tweet = dec_priority[0][1]

            encoded_tweet = urllib.parse.quote(tweet)
            print(encoded_tweet)
            # pt.ptweet(encoded_tweet)
            update_flag = "update tweet_topic set counter_flag = 1 where ID = " + str(dec_priority[0][0]) + " "
            cursor.execute(update_flag)
            conn.commit()
            del dec_priority[0]
            # tweets_count = tweets_count + 1
            time.sleep(10 * configuration["tweetsperhour"])
            
        else:
            break

def executeConfig(conn):

    default_query = "SELECT ID,tweet FROM tweet_topic where "
    configuration = getConfig(conn)

    while(tweets_count < configuration["tweetsperconfig"]):
        #get a new connection
        configuration = getConfig(conn)
        print(configuration)

        if(configuration["customized"] != ""):
            customize(conn)

        #check if specific topic is used.
        elif(configuration["topic"] != ""):
            topic_query = default_query + "topic = '" + configuration["topic"] + "' and"

            if(configuration["incremental"] == 1):
                incremental(topic_query,conn)


            if(configuration["decremental"] == 1):
                decremental(topic_query,conn)


            if(configuration["random"] == 1):
                Random(topic_query,conn)



        #No speicified Topic
        else:
            if(configuration["incremental"] == 1):
                incremental(default_query,conn)
               

            if(configuration["decremental"] == 1):
                decremental(default_query,conn)
                
                
            if(configuration["random"] == 1):
                Random(default_query,conn)
