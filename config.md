
**TIKV
```
./bin/tikv-server --pd="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --addr="10.10.15.148:20160" --status-addr="10.10.15.148:20180" --data-dir=tikv --log-file=tikv.log &
```


** PD SERVER **
```
./bin/pd-server --name=pd1 --data-dir=pd --client-urls="http://10.10.15.143:2379" --peer-urls="http://10.10.15.143:2380 --initial-cluster="pd1=http://10.10.15.143:2380,pd2=http://10.10.15.144:2380,pd3=http://10.10.15.145:2380" -L "info" --log-file=pd.log &
```

**TIDB SERVER
```
./bin/tidb-server --store=tikv --path="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --log-file=tidb.log &
```