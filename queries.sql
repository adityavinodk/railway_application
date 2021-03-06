CREATE TABLE Route (
Route_number SERIAL PRIMARY KEY, 
Number_of_stops INT NOT NULL, 
Distance INT NOT NULL, 
Total_time TIME NOT NULL
);

CREATE TABLE Station (
Station_id SERIAL PRIMARY KEY, 
Station_name VARCHAR(25) NOT NULL
);

CREATE TABLE Person (
User_id SERIAL PRIMARY KEY, 
User_name VARCHAR(25) NOT NULL, 
Age INT NOT NULL, 
Email VARCHAR(50) NOT NULL,
Password VARCHAR(50) NOT NULL
);

ALTER TABLE PERSON ADD UNIQUE (email);

CREATE TABLE Train (
Train_id SERIAL PRIMARY KEY, 
Train_name VARCHAR(25) NOT NULL, 
Seats_available INT NOT NULL, 
Terminal_number INT NOT NULL, 
Status VARCHAR(25) NOT NULL,
Start_station INT NOT NULL,
End_station INT NOT NULL,
Start_date DATE NOT NULL,
Route INT NOT NULL,
FOREIGN KEY (Route) REFERENCES Route(Route_number),
FOREIGN KEY (Start_station) REFERENCES Station(Station_id),
FOREIGN KEY (End_station) REFERENCES Station(Station_id)
);

CREATE TABLE Ticket (
Ticket_number SERIAL PRIMARY KEY, 
Type VARCHAR(25) NOT NULL, 
Berth VARCHAR(25) NOT NULL, 
Availability BOOL NOT NULL, 
Waiting_list BOOL,
Book BOOL,
Train INT NOT NULL,
FOREIGN KEY (Train) REFERENCES Train(Train_id)
);

CREATE TABLE Passenger (
PNR SERIAL PRIMARY KEY, 
Name VARCHAR(25) NOT NULL, 
Age INT NOT NULL, 
Gender CHAR(1)  NOT NULL, 
Status VARCHAR(25),
Train INT NOT NULL,
Booked_by INT NOT NULL,
Ticket INT NOT NULL,
Price INT NOT NULL,
FOREIGN KEY (Train) REFERENCES Train(Train_id),
FOREIGN KEY (Booked_by) REFERENCES Person(User_id),
FOREIGN KEY (Ticket) REFERENCES Ticket(Ticket_number)
);

INSERT INTO route(number_of_stops, distance, total_time) values (12, 252, '10:00:00');
INSERT INTO route(number_of_stops, distance, total_time) values (20, 100, '17:00:00');
INSERT INTO route(number_of_stops, distance, total_time) values (10, 200, '15:00:00');
INSERT INTO route(number_of_stops, distance, total_time) values (16, 134, '19:00:00');
INSERT INTO route(number_of_stops, distance, total_time) values (8, 156, '23:00:00');

INSERT INTO station(station_name) values ('station1');
INSERT INTO station(station_name) values ('station2');
INSERT INTO station(station_name) values ('station3');
INSERT INTO station(station_name) values ('station4');
INSERT INTO station(station_name) values ('station5');

INSERT INTO person(user_name, age, email) values ('Adi', 25, 'e1@gmail.com');
INSERT INTO person(user_name, age, email) values ('Nya', 24, 'e2@gmail.com');
INSERT INTO person(user_name, age, email) values ('Ani', 23, 'e3@gmail.com');
INSERT INTO person(user_name, age, email) values ('Gau', 22, 'e4@gmail.com');
INSERT INTO person(user_name, age, email) values ('Pra', 21, 'e5@gmail.com');

INSERT INTO train(train_name,seats_available,terminal_number,status, start_station, end_station, route, start_date) values('abcdef', 23, 7, 'On Time', 1, 2, 1, '2019-06-01');
INSERT INTO train(train_name,seats_available,terminal_number,status, start_station, end_station, route, start_date) values('agshss', 7, 5, 'Delayed', 1, 5, 4, '2019-08-07');
INSERT INTO train(train_name,seats_available,terminal_number,status, start_station, end_station, route, start_date) values('hbfhuve', 15, 3, 'On Time', 2, 3, 2, '2019-09-10');
INSERT INTO train(train_name,seats_available,terminal_number,status, start_station, end_station, route, start_date) values('hdvhj', 0, 2, 'On Time', 3, 5, 5, '2019-10-09');
INSERT INTO train(train_name,seats_available,terminal_number,status, start_station, end_station, route, start_date) values('sdfsga', 10, 1, 'Delayed', 2, 4, 3, '2019-09-08'); 

INSERT INTO ticket(type, berth, availability, waiting_list, book, train, price) values ('Sleeper', 'Upper', TRUE, FALSE, TRUE, 1, 300);
INSERT INTO ticket(type, berth, availability, waiting_list, book, train, price) values ('Sleeper', 'Lower', TRUE, FALSE, TRUE, 2, 500);
INSERT INTO ticket(type, berth, availability, waiting_list, book, train, price) values ('Sleeper', 'Middle', TRUE, FALSE, TRUE, 3, 800);
INSERT INTO ticket(type, berth, availability, waiting_list, book, train, price) values ('Sleeper', 'Lower', TRUE, FALSE, TRUE, 4, 900);
INSERT INTO ticket(type, berth, availability, waiting_list, book, train, price) values ('Sleeper', 'Upper', TRUE, FALSE, TRUE, 5, 1000);

INSERT INTO passenger(name, age, gender,train, status, booked_by, ticket) values('Ananya', 20, 'F',1, 'Seated', 1, 1);
INSERT INTO passenger(name, age, gender,train, status, booked_by, ticket) values('Aditya', 22, 'M', 2, 'Arriving Soon', 2, 2);
INSERT INTO passenger(name, age, gender,train, status, booked_by, ticket) values('Adi', 19, 'M',1, 'Missed', 3, 3);
INSERT INTO passenger(name, age, gender,train, status, booked_by, ticket) values('Neha', 15, 'F',3, 'Seated', 4, 4);
INSERT INTO passenger(name, age, gender,train, status, booked_by, ticket) values('Anny', 18, 'F',5, 'Seated', 5,5);

SELECT train_id, train_name, Total_time FROM Train INNER JOIN Route ON Train.Route = Route.Route_number WHERE Train.Start_station=1 AND Train.End_station=5;

SELECT Distance as Distance, MIN(Total_time) as Total_time FROM Route WHERE Route_number IN (SELECT Route FROM Train WHERE Start_station=2 AND End_station=3) GROUP BY Distance;

SELECT COUNT(Ticket_number), Berth FROM Ticket WHERE Availability = TRUE GROUP BY Berth ORDER BY Count(Ticket_number) DESC;

SELECT Train_id, Train_name, Terminal_number, Status, Route_number, Total_time, Number_of_stops, Ticket_number, Berth FROM Train INNER JOIN Route ON Train.Route = Route.Route_number INNER JOIN Ticket ON Train.Train_id = Ticket.Train WHERE Train_id=1;

SELECT SUM(Price), COUNT(PNR) from Ticket INNER JOIN Passenger ON Passenger.Ticket = Ticket.Ticket_number WHERE Passenger.Booked_by = 1;