import numpy as np
import matplotlib.pyplot as plt

import BeautifulSoup as bs

def generate_picture():
    
    fig, ax = plt.subplots(figsize=(10, 6), subplot_kw=dict(aspect="equal"))

    new_cases = bs.new_cases()
    new_cases = new_cases[:10]
    data=[int(x.replace(",",'').split()[0]) for x in new_cases]

    print(data)
    # data = [int(x.split()[0]) for x in new_cases]
    countries = [x.split()[-1] for x in new_cases]


    def func(pct, allvals):
        absolute = int(pct/100.*np.sum(allvals))
        return "{:d}".format(absolute)


    wedges, texts, autotexts = ax.pie(data, autopct=lambda pct: func(pct, data),
                                    textprops=dict(color="w"))

    ax.legend(wedges, countries+data,
            title="Top 10 Countries",
            loc="center left",
            bbox_to_anchor=(1, 0, 0.5, 1))

    plt.setp(autotexts, size=8, weight="bold")

    ax.set_title("Corona virus New Cases")

    plt.savefig('stat.png', bbox_inches='tight')