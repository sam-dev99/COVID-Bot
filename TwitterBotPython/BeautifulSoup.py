from bs4 import BeautifulSoup
import requests
import PostTweet as pt

url="https://www.worldometers.info/coronavirus/"

html_content = requests.get(url).text

soup = BeautifulSoup(html_content, "lxml")

corona_table = soup.find("table", attrs={"id": "main_table_countries_today"})
corona_table_data_header = corona_table.thead.find_all("tr")
corona_table_data_body = corona_table.tbody.find_all("tr")


body=[]
for i in range(7, 219):
    test=[]
    for td in corona_table_data_body[i].find_all("td"):
        test.append(td.text.replace('\n', " ").strip().lower())
    body.append(test)
# print(body)



def reply_stat(country_name,status_id,username):
    header=["Total Cases:" , "New Cases:" , "Total Deaths:" , "New Deaths:" , "Total Recovered:" , "Active Cases:"]
    tweet = ""
    for i in range(len(body)):
        if (country_name == body[i][0]):
            for j in range (6):
                if (body[i][j+1] == ''):
                    # print(header[j],"0")
                    tweet += (header[j]+ " " +"0\n")
                else:
                    # print(header[j],body[i][j+1])
                    tweet += (header[j] + " " +  body[i][j+1] + "\n")
    
    pt.reply_to(tweet,status_id,username)



def new_cases():
    test=[]
    for i in range(1, len(body)):
        for j in range (0,1):
            if (body[i][j+2] == ''):
                continue
            else:

                test.append(body[i][j+2][1:]+" "+body[i][j])
    return test
