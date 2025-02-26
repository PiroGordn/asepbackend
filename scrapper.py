from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options
import time

# Twitter Credentials (Replace with your Twitter test account)
USERNAME = "Issuepst"
PASSWORD = "Arsb?~123"

# Setup Selenium
options = Options()
options.add_argument("start-maximized")
options.add_argument("--disable-blink-features=AutomationControlled")  # Helps bypass bot detection

service = Service("D:/twitter_scraper/chromedriver.exe")  # Ensure this path is correct
driver = webdriver.Chrome(service=service, options=options)

# Move the window out of the screen (instead of minimizing)
driver.set_window_position(3000, 0)  # Moves the window far to the right (adjust as needed)
print("✅ Chrome window moved out of view.")

# Step 1: Open Twitter Login Page
driver.get("https://twitter.com/login")
time.sleep(5)  # Allow time for the page to load

# Step 2: Enter Username
try:
    username_input = driver.find_element(By.XPATH, "//input[@name='text']")
    username_input.send_keys(USERNAME)
    username_input.send_keys(Keys.ENTER)
    time.sleep(3)
except Exception as e:
    print("❌ Failed to enter username:", e)
    driver.quit()

# Step 3: Enter Password
try:
    password_input = driver.find_element(By.XPATH, "//input[@name='password']")
    password_input.send_keys(PASSWORD)
    password_input.send_keys(Keys.ENTER)
    time.sleep(5)  # Allow time for login to process
except Exception as e:
    print("❌ Failed to enter password:", e)
    driver.quit()

# Step 4: Check If Login Was Successful
current_url = driver.current_url
if "login" in current_url:
    print("❌ Login failed! Please check your credentials.")
    driver.quit()
else:
    print("✅ Successfully logged into Twitter!")

# Step 5: Search for Tweets
search_query = "Python scraping"
search_url = f"https://twitter.com/search?q={search_query}&src=typed_query&f=live"
driver.get(search_url)
time.sleep(5)  # Allow time for search results to load

# Step 6: Extract Tweets
tweets = driver.find_elements(By.XPATH, '//div[@data-testid="tweetText"]')

# Step 7: Print Found Tweets
print("\n🔍 **Similar Tweets Found:**")
if tweets:
    for tweet in tweets[:5]:  # Limit to first 5 tweets
        print("-", tweet.text)
else:
    print("⚠️ No tweets found.")

# Step 8: Close Browser
driver.quit()
