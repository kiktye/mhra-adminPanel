<a name="top"></a>

## 🚀 About

The **Macedonian Human Resource Association (MHRA) Admin Panel** is designed to manage the content that will be displayed on the MHRA website. This admin panel provides the admin with the ability to create, read, update, and delete (CRUD) resources that will reflect on the public website.

## Resources

### Users Management

-   View all users registered in the system.
-   Restrict users if they've violated terms (optional).
-   View details such as blogs written by users, comments on their blogs.
-   Manage friend lists, view given and received recommendations between users.

### Employees & Roles

-   View and manage employees, including editing or deleting their information.
-   Add new employees with fields such as name, surname, photo, title, description, and social links.
-   Assign positions to employees. If a position is not available, you can create a new role/position directly in the system.

### Blogs Management

-   View blog details, including the author, comments, and likes.
-   Moderate comments: remove inappropriate ones or restore them if needed.
-   Feature blogs with a single click, placing them at the top of the blog listing page on the frontend.
-   Update blog images, titles, descriptions, and individual sections, or remove unwanted sections.
-   View related blogs linked to the current blog.

### Events Management

-   Manage event details such as location, time, and speaker information.
-   Remove or edit event speakers as necessary.
-   Manage ticket prices, including defining ticket types and prices.
-   Feature events to appear at the top of the Events Listing page (frontend).
-   Update event images, titles, themes, objectives, and descriptions.
-   View and manage the event’s agenda, including adding sections by hour or day, and adding new days to multi-day events.
-   View related events with links to access them.

### Annual Conference Management

-   Conferences can have one of three statuses: active, inactive, or canceled.
-   Active: The current year’s conference.
-   Inactive: Previous conferences or upcoming conferences still in preparation.
-   Manage conference details such as location, time, speakers, and special guests.
-   Configure ticket packages, including options that come with each ticket type.
-   Update the conference image, title, description, and agenda.
-   Change the status of the conference as needed.

### Agenda Tool Builder

-   Create and name unique agendas.
-   Dynamically add new days (e.g., "Day 1") or assign specific dates.
-   Add hours, points, and subpoints for each agenda section, all dynamically.

### Speaker

-   Add new speakers by entering their information.
-   Specify whether the speaker is a special guest (for conferences only).
-   Save speakers to events or conferences as needed.

# Agenda Management

Both **events** and **conferences** include an **agenda** timeline, and the admin panel provides a dedicated tool for managing the agenda. The admin can create agendas for one or multiple days and link them to events or conferences.

## Features

### Full Control for Admins:

-   CRUD functionality for Users, Employees, Blogs, Events, Conferences, Speakers.
-   Can manage the home page.
-   Ability to plan and manage agendas for both events and conferences.

### Scalable Database:

-   The database schema is designed for flexibility, allowing for easy future changes like adding new tables or updating existing ones.

### User Interface:

-   The admin panel has a custom UI, designed by me which I find to be user-friendly for the admins. Admins have full control over the resources, and the interface makes it easy to navigate and manage content.

## 📝 How to Set Up

To set up the admin panel, follow these steps:

```shell
# Open a terminal

# Ensure Git is installed
# Visit https://git-scm.com to download and install console Git if not already installed

# Clone the repository
git clone https://git.brainster.co/Kiko.Stojanov-FS15/bp-kikostojanovfs15.git
git checkout project03

# Install dependencies
composer install
npm install

# Set up the environment file
cp .env.example .env

# Generate application key:
php artisan key:generate

# Configure your database in the .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mhra_admin
DB_USERNAME=root
DB_PASSWORD=

# Run migrations to set up the database
php artisan migrate

# Seed the database for dummy data
php artisan db:seed

# Link storage
php artisan storage:link

# Run the local server
php artisan serve
npm run dev


```

## 📚 Documentation

After seeding the database, you can log in as an administrator using the following credentials:

```shell
Email: admin@mhra.com
Password: secret
```

As an admin, you can manage users, including restricting access for those who have violated terms. You can view the blogs written by each user, along with all comments and likes. You can also access their friend list and see the recommendations they've given and received from other users. Additionally, you can manage employee information, such as editing, deleting, or adding new employees with details like name, photo, title, and social links. You can assign a position to each employee, and if the position doesn’t exist, you can create a new role directly from the panel.

In the Blogs section, you can view detailed information about each blog, including the author, comments, and likes. You can moderate comments by removing inappropriate ones or restoring them if needed. Blogs can be featured with a single click, and you'll have the ability to edit the title, description, images, and individual sections. You can also view related blogs.

For events, you can manage the event details, including time, location, and speaker information. You can remove speakers if necessary and adjust ticket pricing. Like blogs, events can also be featured on the frontend. You can edit the event’s agenda by adding sections, subtitles, or even new days. Related events are also shown.

For the Annual Conference, there are three statuses: active, inactive, or canceled. You can manage details such as the conference date, location, speakers, special guests, and ticket packages. You can also edit the agenda, title, and description, and change the conference status as needed.

The Agenda Tool allows you to build a unique agenda, dynamically adding days, hours, points, and subpoints. Finally, you can add new speakers to events or conferences, and if they’re special guests, they can be tied specifically to a conference.

## User Manual

I think the UI/UX is pretty self explanatory, although there is some stuff I need to address.
In order to create Event or Conference, the Agenda needs to be created first. Then on the Page for creating Event/Conference there is the option to choose the specific agenda you want to use, which you can recognize by the unique name you can give your Agenda.
If you're creating Agenda for an Event, which is single day, I suggest typing the actual date ( ex. 25 July 2024 ), if you're creating an agenda for a conference which can be multi day, I would suggest to be Day 1, Day 2...
The speakers are added after the Event or Conference is created and written into the system.
If you choose the speaker to be a special guest, you can only save it for a Conference.

## 🗨️ Contacts

For any questions or further details,
contact the project creator at [kikostojanov4466@yahoo.com].

[Back to top](#top)
