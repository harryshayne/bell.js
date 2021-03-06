// Demo alerter module

'use strict';

exports.init = function(configs, alerter, log) {
  alerter.on('anomaly detected', function(event) {
    var trend = event[1];
    var datapoint = event[0];
    log.info('Anomaly detected, datapoint: %s, trend: %d',
            datapoint, trend);
  });
};
