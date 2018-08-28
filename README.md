# MotorK PHP Assignment

## Execution

The test was done using the given structure, so the web / index.php file was used as the entry point of the site, in the class CarController was put all the controller logic, while the view files were placed in the views folder.

In the entry point file the object of the CarController class is created, its methods are used to recall the views's pages.
Here it is also create a PDO object used for the task with the db. This object is passed to the CarController object as an attribute

### db

The db has only the lead table with this structure:

```
CREATE TABLE Leads (
Id INTEGER PRIMARY KEY AUTOINCREMENT, 
Name TEXT NOT NULL, 
Lastname TEXT NOT NULL, 
Email CHAR(250) NOT NULL, 
Phone CHAR(25) NOT NULL, 
Cap CHAR(10) NOT NULL, 
Privacy INTEGER NOT NULL, 
CarId CHAR(10) NOT NULL, 
InsertData TEXT NOT NULL
)
```
InsertData is for the timestamp of the inserted records

In home page the html is basically the same of the legacy page.

Here the list of cars is got from the API call and showed with a foreach loop.
Each car's article is put into an link tag, so the user can click on it to go to the details page

### Detail page

In the detail pages the car is shown with all the details returned by the specific API call.
Next to there is the contact form and below there is the section with the suggested cars.

The IdCar passed with the url is check in the controller, if it is null, controller return the view "detail_nocar". A sort of 404 page with a message and a link to return to home.

## The Request Form

At first the action for sending the form was the same url of the detail page.
The getDetail method checks for the presence of POST data and in positive case it calls the method saveRequest to insert them in the db.
If Insert got successful, the form is not shown and a confirmation message is show in its place.
In case of failure, the form is reloaded with the data sent.

But then I prefer another solution with a piece of javascript and send data with a AJAX action.

For the send, a new url was define "/saveform" with a new method in CarController.
This retrieves the post data and invokes the same saveRequest method.
The answer is a json format with a parameter that signals any possible errors.
The script alerts the result with an alert function. It 's not a real good UX solution, but for this test it works

I did not implement a very sophsticated controller on the values from the form, but I used to pass them with the PDO function bindParam to avoid some injection risck


## Part 2: Suggestion engine

The suggested cars are chosen according to the distance from the selected car.

The idea is if we place place cars on a hypothetical XY chart, cars with similar characteristics will be in close positions.
So I tried to define a metric to calculate the distance between the cars.
For numerical characteristics, such as price, consume, weight, metric is a simple arithmetic subtraction.
For qualitative characteristics, such as design, segment, type of fuel, I have chosen to assign the value 0 if the value are the same, 1 if it is different.
So I got a distance measurement for each individual characteristic, and then I calculate the vector distance to get the distance with two car.
In the end the cars were sorted by distance, in descending order, and shown only those with a distance less than a threshold.
The threshold was defined arbitrarily after a series of tests.


## Test Unit
unfortunately PHPUnit is not my cup of tea, so I just defined the class to test the CarController




