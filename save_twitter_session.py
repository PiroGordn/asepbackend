from selenium import webdriver
import pickle
import time

# Open Twitter login page
driver = webdriver.Chrome()
driver.get("https://twitter.com/login")

input("🔵 Log in manually, then press ENTER here...")  # Wait for manual login

# Save cookies
pickle.dump(driver.get_cookies(), open("twitter_cookies.pkl", "wb"))
print("✅ Twitter login session saved!")
driver.quit()
