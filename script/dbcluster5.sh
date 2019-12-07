#!/bin/sh

./tidb-v3.0-linux-amd64/bin/tikv-server --pd="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --addr="10.10.15.147:20160" --status-addr="10.10.15.147:20180" --data-dir=tikv --log-file=tikv.log &