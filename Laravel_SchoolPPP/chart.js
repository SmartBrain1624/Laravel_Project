var exec = require('child_process').exec;
var cmd = './node_modules/.bin/highcharts-export-server --enableServer 1';

exec(cmd, function(error, stdout, stderr) {
  // command output is in stdout
});