# TIDB CLuster Database Implementation and Testing
## System Set up and specification
| IP            | RAM    | Services  | Hostname   |
|---------------|--------|-----------|------------|
|  10.10.15.143 | 1024MB | TiDB + PD | dbcluster1 |
| 10.10.15.144  | 512MB  | PD        | dbcluster2 |
| 10.10.15.145  | 512MB  | PD        | dbcluster3 |
| 10.10.15.146  | 512MB  | TIKV      | dbcluster4 |
| 10.10.15.147  | 512MB  | TIKV      | dbcluster5 |
| 10.10.15.148  | 512MB  | TIKV      | dbcluster6 |
| 10.10.15.159  | 2048MB | Apache+PHP +Prometheus +grafana | machine1 |

## TiDB Cluster Setup
1. create 6 vagrant virtual machine with the above config
2. create provision script to setup vagrant machine ( increasing os openfile limit, downloading tidb file, creating user for tidb, and turn off firewall)
3. RUN TIDB Services
   1. PD Server ( run on dbcluster 1,2,3) change ip to match machine ip
    ```
    ./bin/pd-server --name=pd1 --data-dir=pd --client-urls="http://10.10.15.143:2379" --peer-urls="http://10.10.15.143:2380" --initial-cluster="pd1=http://10.10.15.143:2380,pd2=http://10.10.15.144:2380,pd3=http://10.10.15.145:2380" -L "info" --log-file=pd.log &
    ```
   2. RUN TIKV Server ( on cluster 4,5,6)
    ```
    ./bin/tikv-server --pd="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --addr="10.10.15.148:20160" --status-addr="10.10.15.148:20180" --data-dir=tikv --log-file=tikv.log &
    ```
   3.  RUN TiDB Server ( on cluster 1)
    ```
    ./bin/tidb-server --store=tikv --path="10.10.15.143:2379,10.10.15.144:2379,10.10.15.145:2379" --log-file=tidb.log &
    ```
   4. Be sure to run these steps above eachtime you restart vagrant machines
## TiDB Cluster Monitoring Setup
1. Install node exporter pada setiap server pd dan salah satu tikv server
   ```
   wget https://github.com/prometheus/node_exporter/releases/download/v0.15.2/node_exporter-0.15.2.linux-amd64.tar.gz
   tar -xzf node_exporter-0.15.2.linux-amd64.tar.gz
   cd node_exporter-0.15.2.linux-amd64
   ./node_exporter-0.15.2.linux-amd64/node_exporter --web.listen-address=":9100" --log.level="info" &
   ```
2. pada node yang akan dijadikan monitor service, extract prometheus dan edit configurasi nya menjadi seperti yang sudah disediakan pada folder config
3. jalankan prometheus
```
./prometheus --config.file="./prometheus.yml" --web.listen-address=":9090" --web.external-url="http://10.10.15.149:9090/" --web.enable-admin-api --log.level="info" --storage.tsdb.path="./data.metrics" --storage.tsdb.retention="15d" &
```
4. extract grafana dan copy config yang sudah dibuat sebelum nya kedalam folder conf/ di dalam folder grafana
5. jalan kan grafana
```
./bin/grafana-server --config="./conf/grafana.ini" &
```
6. Web grafana sudah bisa dibuka di localhost:3000. Login dengan username dan password admin.
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/grafana%20login.png)
7. tambahkan prometheus datasource. Buka menu data source dan pilih add new data source
8. Tuliskan nama yang diinginkan, url prometheus yang sebelum nya sudah di set, dan pilih tipe datasource menjadi prometheus
9. Import dashboard yang sudah disediakan di folder config. 
10. Dashboard yang sudah diimport bisa di modifikasi untuk memunculkan grafik atau informasi yang diinginkan.
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/grafana.png)
11. Tambahan : segala command pada step ini bisa dibuat kedalam bash script agar mempermudah saat restart server

## Installing Application
1. Download app requirement. We will be using Laravel app, so be sure to download all php and apache requirements and composer
https://www.howtoforge.com/tutorial/centos-lamp-server-apache-mysql-php/
2. in laravel .env, change the db settings to use our created TiDB instance
3. Put the app in machine1 vm.
4. now you can test the app in host machine in port 8080

### Application Description
This is a simple application to manage a small store transactions. The store owner can store what item to sale, how much the stock, price and the image. then he can store each transaction in the store to the database. the store owner can also manage his staff.

Usecase :
* Create item
* edit item
* delete item
* modify item stock
* view list of item
* create transaction
* view list of transaction
* edit transaction
* delete transaction
* Create new staff
* delete staff

Access Control :
* staff can only create new item, change the item stock, view the list of item and create new transaction
* Owner has full access of all feature

## Testing & Benchmark
### JMeter Load Test
1. 100 Connection
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/100.png)
2. 500 Connection
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/500.png)
3. 1000 Connection
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/1000.png)

as we can see, the app can easily handle 500+ request, the server start lagging when the request reach up to 600+

### Sysbench Tidb benchmark
Every Benchmark we will test using 2 tables with 10K row each
1. 1 PD Server
   Testing on 1PD server result in failure. Because we initiate first with clustered PD, we cant have only one of pd up
2. 2 PD Server
```
SQL statistics:
    queries performed:
        read:                            772492
        write:                           0
        other:                           110356
        total:                           882848
    transactions:                        55178  (183.62 per sec.)
    queries:                             882848 (2937.98 per sec.)
    ignored errors:                      0      (0.00 per sec.)
    reconnects:                          0      (0.00 per sec.)

General statistics:
    total time:                          300.4932s
    total number of events:              55178

Latency (ms):
         min:                                  345.32
         avg:                                  696.59
         max:                                13727.62
         95th percentile:                      816.63
         sum:                             38436252.21

Threads fairness:
    events (avg/stddev):           431.0781/2.30
    execution time (avg/stddev):   300.2832/0.16
```
3. 3 PD Server
```
SQL statistics:
    queries performed:
        read:                            822850
        write:                           0
        other:                           117550
        total:                           940400
    transactions:                        58775  (195.60 per sec.)
    queries:                             940400 (3129.67 per sec.)
    ignored errors:                      0      (0.00 per sec.)
    reconnects:                          0      (0.00 per sec.)

General statistics:
    total time:                          300.4769s
    total number of events:              58775

Latency (ms):
         min:                                  287.28
         avg:                                  653.88
         max:                                 1252.72
         95th percentile:                      816.63
         sum:                             38431992.07

Threads fairness:
    events (avg/stddev):           459.1797/2.70
    execution time (avg/stddev):   300.2499/0.14 
```

as we can see, our database can easily handle 128 threads, looking at same latency between 2 server and 3 pd server

### Failover Test
we test to drop one of the TIKV data store server. then we check data availability, create new data and turn on the server again to check if the new server get the data and becomes the slave server.
1.Shutdown one of the tikv
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/failover.png)
2.Create new data
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/failover1.png)
3. Turn on tikv again (log result)
![](https://github.com/adhityairvan/fp-bdt/raw/master/pictures/failover2.png)

the tikv server that we turn off becomes slave and the data is still safe
