# TodoList

TodoList is a work management system with features for managing tasks and displaying them on a calendar.
![Calendar View](image.png)

## Main Features

1. **Add, Edit, Delete Tasks**

   - A task includes the following information:
     - Work Name
     - Starting Date
     - Ending Date
     - Status (Planning, Doing, Complete)

2. **Display Tasks on a Calendar**
   - Display tasks in Day, Week, Month views

## Installation and Running the Project

### Requirements

- Docker

### Installation

1. Clone the repository:

   ```sh
   git clone https://github.com/yourusername/TodoList.git
   ```

### Running the Project

1. create container:

   ```sh
   docker-compose up -d
   ```

2. Open your browser and navigate to:

   ```sh
   http://localhost:81
   ```

### command:

1. Access the application container:

   ```sh
   docker exec -it todoList bash
   ```

2. View the application logs:

   ```sh
   docker logs -f todoList
   ```

3. Run database migrations for the testing environment:

   ```sh
   php vendor/bin/phinx migrate -e testing
   ```

4. Run database migrations for the default environment:

   ```sh
   php vendor/bin/phinx migrate
   ```

5. Seed the database:

   ```sh
   php vendor/bin/phinx seed:run
   ```

## Directory todoList Structure

- `/todoList`
  - `/app`
    - `/Controllers` - logic.
    - `/Database` - setup connection.
    - `/Models` - do query.
    - `/Views` - UI.
  - `/db`
    - `/migrations` - migrate database.
    - `/seeds` - seed example data.
  - `/test`
    - `/Feature` - test controller.
    - `/Unit` - test function.

## Using Third-Party Libraries

### Calendar Display

To display the calendar, you can use the [FullCalendar](https://fullcalendar.io/) or [react-calendar](https://github.com/wojtekmaj/react-calendar) library. Below is an example of how to use FullCalendar:

1. Install FullCalendar:

   ```sh
   npm install @fullcalendar/react @fullcalendar/daygrid @fullcalendar/timegrid
   ```

2. Use FullCalendar in your project:

   ```jsx
   // src/components/CalendarView.js
   import React from "react";
   import FullCalendar from "@fullcalendar/react";
   import dayGridPlugin from "@fullcalendar/daygrid";
   import timeGridPlugin from "@fullcalendar/timegrid";

   const CalendarView = ({ events }) => {
     return (
       <FullCalendar
         plugins={[dayGridPlugin, timeGridPlugin]}
         initialView="dayGridMonth"
         events={events}
       />
     );
   };

   export default CalendarView;
   ```

## Contribution

If you want to contribute to the project, please create a pull request or open an issue on GitHub.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.
