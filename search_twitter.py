from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time
import sys
import json

query = sys.argv[1]

options = webdriver.ChromeOptions()
options.add_argument("--headless")

driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)
driver.get(f"https://twitter.com/search?q={query}&f=live")

time.sleep(5)

tweets = driver.find_elements(By.CSS_SELECTOR, 'article div[lang]')
tweet_texts = [tweet.text for tweet in tweets[:5]]

driver.quit()

print(json.dumps(tweet_texts))
