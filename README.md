# WordPress Plugin Development Tutorial

## Description

This WordPress Plugin allows a WordPress Website to display Particular Products with their Description (price, weight, color, etc). The Description is added by the website Administrator and can change them in time.

Product Categories can be Edited appropriately in Source Code.

## Technology Used

- Language: **HTML**, **PHP** & **MySQL**
- Text Editor: **Brackets**
- Web Server & Database Hosting: **XAMPP** or **WAMP** 

This Plugin is locally hosted and tested properly.

## How To Activate Plugin

- **Download** the Plugin
- **Extract** to any Folder

For **XAMPP** Users
- **Create** a Folder called *halloween-plugin* at **./XAMPP/htdocs/WordPress-Website/wp-content/plugins/**
- **Copy** both *PHP files* to **./XAMPP/htdocs/WordPress-Website/wp-content/plugins/halloween-plugin**

OR For **WAMP** Users
- **Create** a Folder called *halloween-plugin* at **./WAMP/www/WordPress-Website/wp-content/plugins/**
- **Copy** both *PHP files* to **./WAMP/www/WordPress-Website/wp-content/plugins/halloween-plugin**

Then
- **Open** any Browser
- **Open** the Website **http://localhost/WordPress-Website/wp-admin**
- **Enter** Administrator Credentials and Login
- Go to **Plugins** Tab
- **Activate** the **Product Catalog** Plugin

The Plugin is Activated and can be used on your WordPress Website.

## Working w/ Jing Video

Jing Reference: http://screencast.com/t/6iQGxe0e3

## Working w/ Screenshots

1. Activating Plugin
  Plugin Must be Activated before being used on the Website. Click **Plugin** and then Click **Activate** under **Product Catalog**
![Activating Plugin](http://i.imgur.com/gzHPEvh.png)

2. Product Custom Post
  After the Plugin is Activated, A **Product** Custom Post Type will Appear on the left Tab of the Admin-Menu. Click it. Product Descriptions can be **Added**, **Deleted** and **Ammended**  here
![Product Custom Post](http://i.imgur.com/mm3k41v.png)

3. Adding New Product to Catalog
  New Products **Title**, **Description**, **SKU**, **Price**, **Weight**, **Color** and **Category** is set here
![New Product](http://i.imgur.com/UhAR8fO.png)

4. Halloween Product Settings
  Product **Settings** can be ammended, You can either chose to switch **Currency Sign** on/off or **Change Currency Sign** from **$** to **£**
![Halloween Product Settings](http://i.imgur.com/A1vHLxN.png)

5. Widget Activation/Setup
  To Display this Plugin Details on your WordPress Website, The **Widget** that displays these details must first be enabled from this **Setup Page**
![Widget Setup](http://i.imgur.com/53TBvmr.png)

6. Product Catalog on Website
  Product Description Displayed According to Your **Widget View Settings**
![Catalog on Website](http://i.imgur.com/Jh3GBP4.png)

## Code 

The Code uses **actions** and **filters** to accomplish its task using appropriate **hooks**

- Reference List For Actions: https://codex.wordpress.org/Plugin_API/Action_Reference
- Reference List For Filters: https://codex.wordpress.org/Plugin_API/Filter_Reference
- Reference List For Hooks: https://codex.wordpress.org/Plugin_API/Hooks

More References can be Looked At Codex: https://codex.wordpress.org/

## Note 

The **WP_Widget** Class uses a **_deprecated_** constructor and can only be used if your **Debug** is set to **False** in **_wp-config.php_** file.

## Credits

This Plugin Was Created By **Danyal Imran** for learning Purposes using **Professional WordPress 2nd Edition** Book. The Book already describes about this Plugin in **Chapter 8 - Plugin Development** but using **Internationalization**. **Internationalization** has been removed to keep this Plugin in English Language.

Digital Reference to Professional WordPress 2nd Edition: http://www.stilson.net/documentation/Professional%20WordPress,%202nd%20Edition.pdf

## Disclaimer

In case of any fault or problems caused by this Plugin, I am not responsible for any damage caused. 
**_USE AT YOUR OWN RISK_**.

## Contact

If you have Questions, feel free to contact me:
- Facebook: http://facebook.com/fuNkyBRO1
- Email: k132089@nu.edu.pk
