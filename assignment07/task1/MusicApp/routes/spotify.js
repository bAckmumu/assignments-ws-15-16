var express = require('express');
var router = express.Router();

router.use(express.static(path.join(__dirname, '../spotifysearch')));

module.exports = router;