var express = require('express');


var spotify = require('./spotify');

var router = express.Router();

router.use('/spotify', spotify);

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

module.exports = router;
