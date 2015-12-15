var express = require('express');
var router = express.Router();

var spotify = require('./spotify');


router.use('/spotify', spotify);

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

module.exports = router;
