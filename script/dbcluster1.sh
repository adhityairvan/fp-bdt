#!/bin/sh

./tidb-v3.0-linux-amd64/bin/pd-server --name=pd1 --data-dir=pd --client-urls="http://10.10.15.143:2379" --peer-urls="http://10.10.15.143:2380" --initial-cluster="pd1=http://10.10.15.143:2380,pd2=http://10.10.15.144:2380,pd3=http://10.10.15.145:2380" -L "info" --log-file=pd.log &
./tidb-v3.0-linux-amd64/bin/tidb-server --store=tikv --path="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --log-file=tidb.log &
./node_exporter-0.15.2.linux-amd64/node_exporter --web.listen-address=":9100" --log.level="info" &
