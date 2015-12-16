var express = require('express');
var path = require('path');

var router = express.Router();

var shoot = require('./shoot');

router.use('/shoot', shoot);
router.use('/screenshots', express.static(path.join(__dirname, '../screenshots')));

module.exports = router;
