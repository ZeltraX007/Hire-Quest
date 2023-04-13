const express = require("express");
const app = express();
const mysql = require('mysql');
const bodyParser = require('body-parser');
const multer = require('multer');
const Chart = require('chart.js')

app.use(bodyParser.urlencoded({ extended: false }));

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'Dini7777',
  database: 'Hirequest'
});

const upload = multer({ storage: multer.memoryStorage() });
app.post("/addstudent", upload.single('cv'), (req, res) => {
  const resume = req.file.buffer.toString('base64');
  const Name = req.body.name;
  const Email = req.body.email;
  const Number = req.body.phone;
  const Gender = req.body.gender;
  const Dob = req.body.DOB;
  const Graduation = req.body.graduation;
  const Address = req.body.address;
  const city = req.body.city;
  const state = req.body.state;
  const code = req.body.zip;
  const q = "INSERT INTO students (name, email, phone,gender,Dob,Graduation,Address,city,state,zip, Resume) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
  connection.query(q, [Name, Email, Number, Gender,Dob,Graduation,Address,city,state,code,resume], (err, rows, fields) => {
    if (err) {
      console.log(err);
      res.sendStatus(500);
      return;
    }
    res.redirect("/add.html");
  });
});



app.post("/update", upload.single('cv'), (req, res) => {
  const resume = req.file.buffer.toString('base64');
  const Name = req.body.name;
  const Email = req.body.email;
  const Number = req.body.phone;
  const Gender = req.body.gender;
  const Dob = req.body.DOB;
  const Graduation = req.body.graduation;
  const Address = req.body.address;
  const city = req.body.city;
  const state = req.body.state;
  const code = req.body.zip;
  const studentId = req.body.id; // assuming there is a student ID field in the form

  const q = `UPDATE students SET 
  name=?, 
  gender=?, 
  phone=?, 
  email=?, 
  Dob=?, 
  city=?, 
  state=?, 
  zip=?, 
  Graduation=?, 
  Address=?, 
  Resume=?
  WHERE student_id=?`;

  connection.query(q, [Name, Gender, Number, Email, Dob, city, state, code, Graduation, Address, resume, studentId], (err, rows, fields) => {
    if (err) {
      console.log(err);
      res.sendStatus(500);
      return;
    }
    res.redirect("/editStudent");
  });
});


app.use(express.static('views'));


app.get('/checkStudents', (req, res) => {
    const q = "SELECT * FROM students";
    connection.query(q, (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('checkStudents', { students: rows });
    });
  });

  app.get('/deleteStudents', (req, res) => {
    const q = "SELECT * FROM students";
    connection.query(q, (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('deleteStudents', { students: rows });
    });
  });

  app.get("/deletestudent/:id", (req, res) => {
    sid = (req.params.id);
    const q = "DELETE FROM students WHERE student_id = ?";
    connection.query(q, [sid], (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.redirect("/deleteStudents");
    });
  });
  
  app.get('/editStudent', (req, res) => {
    const q = "SELECT * FROM students";
    connection.query(q, (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('editStudent', { students: rows });
    });
  });

  app.get('/editing/:id', (req, res) => {
     sid = (req.params.id)
    const q = "SELECT * FROM students where student_id = ?";
    connection.query(q,[sid], (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('editing', { students: rows });
    });
  });
  
  app.get('/ed_search', function(req, res) {
    var qu = req.query.query; 
    const q = "SELECT * FROM students WHERE student_id = ?";
    connection.query(q, [qu], (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('editStudent', { students: rows });
    });
  });

  app.get('/search', function(req, res) {
    var qu = req.query.query; 
    const q = "SELECT * FROM students WHERE student_id = ?";
    connection.query(q, [qu], (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('checkStudents', { students: rows });
    });
  });

  app.get('/delsearch', function(req, res) {
    var qu = req.query.query; 
    const q = "SELECT * FROM students WHERE student_id = ?";
    connection.query(q, [qu], (err, rows) => {
      if (err) {
        console.log(err);
        res.sendStatus(500);
        return;
      }
      res.render('deleteStudents', { students: rows });
    });
  });
  
  
app.set('view engine', 'ejs');


app.listen(3000, () => {
  console.log("Listening on port 3000");
});

