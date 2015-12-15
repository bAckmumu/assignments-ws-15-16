var express = require('express');
var path = require('path');
var webshot = require('webshot');

var router = express.Router();

var screenShotPath = path.join(__dirname, '../screenshots');
console.log('shoot.js screenShotPath: %j', screenShotPath);

router.use('/screenshots', express.static(screenShotPath));



router.get('/', function (req, res) {
	
	var url = req.query.url;
	console.log('shoot.js url: %j', url);

	var fileName = url + '.png';
	console.log('shoot.js fileName: %j', fileName);

	var filePath = path.join(screenShotPath, url);
	console.log('shoot.js filePath: %j', filePath);

	webshot(url, filePath, function(err) {
		
	});

	var obj = {
		"status": "ok",
		"path": path.join('/screenshots', fileName),
		"message": "new screenshot" 
	};
	console.log('shoot.js obj: %j', obj);

	// var obj = { 
	// 	"status": "ok",
	// 	"path": "/shoot/screenshots/google.de.png", 
	// 	"message": "re-used screenshot"
	// };

	res.send(obj);
});




module.exports = router;