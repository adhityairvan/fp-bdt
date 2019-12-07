#!/bin/sh

./tidb-v3.0-linux-amd64/bin/tikv-server --pd="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --addr="10.10.15.146:20160" --status-addr="10.10.15.146:20180" --data-dir=tikv --log-file=tikv.log &
./node_exporter-0.15.2.linux-amd64/node_exporter --web.listen-address=":9100" --log.level="info" &
