var express = require('express');
var path = require('path');
var webshot = require('webshot');

var router = express.Router();

var screenShotPath = path.join(__dirname, '../screenshots');
console.log('shoot.js screenShotPath: %j', screenShotPath);

router.use('/screenshots', express.static(path.join(__dirname, '../screenshots')));



router.get('/', function (req, res) {
	
	var url = req.query.url;
	console.log('shoot.js url: %j', url);

	var fileName = encodeURIComponent(url) + '.png';
	console.log('shoot.js fileName: %j', fileName);

	var filePath = path.join(screenShotPath, fileName);
	console.log('shoot.js filePath: %j', filePath);

	webshot(url, filePath, function(err) {
		var obj = {
			"status": "ok",
			"path": path.join('/screenshots', fileName),
			"message": "new screenshot" 
		};
		console.log('shoot.js obj: %j', obj);

		res.send(obj);
	});

	//webshot('google.com', 'google.com.png', function(err) {
	//	// screenshot now saved to google.png
	//});

	
	// var obj = { 
	// 	"status": "ok",
	// 	"path": "/shoot/screenshots/google.de.png", 
	// 	"message": "re-used screenshot"
	// };

	
});




module.exports = router;