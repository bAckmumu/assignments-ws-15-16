var express = require('express');
var router = express.Router();

var shoot = require('./shoot');

router.use('/shoot', shoot);


module.exports = router;
