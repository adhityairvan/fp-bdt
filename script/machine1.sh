#!/bin/sh

./prometheus-2.2.1.linux-amd64/prometheus --config.file="./prometheus-2.2.1.linux-amd64/prometheus.yml" --web.listen-address=":9090" --web.external-url="http://10.10.15.149:9090/" --web.enable-admin-api --log.level="info" --storage.tsdb.path="./data.metrics" --storage.tsdb.retention="15d" &

pushd ./grafana-4.6.3
./bin/grafana-server --config="./conf/grafana.ini" &
popd