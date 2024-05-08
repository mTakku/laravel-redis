<p align="center" >
  <b>POINT UTAMA</b>
</p>

---

> #### INSTALASI
> - PHP 8.1.0
> - LARAVEL 10.0.3
>   ```
>   Composer Create-project laravel\laravel=v10.0.3 laravel-redis
>   ```
> - REDIS
> - Tutorial instalasi redis
>   ```
>   https://www.youtube.com/watch?v=DLKzd3bvgt8&ab_channel=TrendingCode
>   ```
> - Jika sudah pergi ke terminal dan masukan syntax ```redis-server```
---
> #### APA REDIS?
> Redis adalah salah satu database in Memory yang paling populer di dunia
> banyak fitur di laravel bisa menggunakan redis seperti cache, session sampai rate limiting
> 
> #### REDIS COMMAND
> - Untuk mengirim perintah ke redis, kita bisa menggunakan method command() di redis facade
> - atau bisa langsung menggunakan nama method sesuai dengan command di redis
>
> Berikut contoh ping redis:
>
> ```
> $response = Redis::command("ping");
> self::assertEquals("PONG", $response);
>
> $response = Redis::ping();
> self::assertEquals("PONG", $response);
> ```
>
> #### STRING
> - Command yang sering kita gunakan adlaah menggunakan set(),setEX(), M
>
> Berikut contoh kode manipulasi collection :
> ```
> Redis::setex("name", 2, "Farel");
> $response = Redis::get("name");
> self::assertEquals("Farel", $response);
>
> sleep(5);
>
> $response = Redis::get("name");
> self::assertNull($response);
> ```
>
> #### LIST
> - 
>
> Berikut salah satu contoh kode list :
> ```
> Redis::del("names");
>
> Redis::rpush("names", "Farel");
> Redis::rpush("names", "Mercys");
> Redis::rpush("names", "Thona");
>
> $response = Redis::lrange("names", 0, -1);
> self::assertEquals(["Farel", "Mercys", "Thona"], $response);
>
> self::assertEquals("Farel", Redis::lpop("names"));
> self::assertEquals("Mercys", Redis::lpop("names"));
> self::assertEquals("Thona", Redis::lpop("names"));
> ```
> #### SET
> - 
>
> Berikut contoh kode set :
>
> ```
> Redis::del("names");
> 
> Redis::sadd("names", "Farel");
> Redis::sadd("names", "Farel");
> Redis::sadd("names", "Mercys");
> Redis::sadd("names", "Mercys");
> Redis::sadd("names", "Thona");
> Redis::sadd("names", "Thona");
>
> $response = Redis::smembers("names");
> self::assertEquals(["Farel", "Mercys", "Thona"], $response);
> ```
---
> #### SORTED SET
> - 
>
> Berikut contoh kode sorted set :
> ```
> Redis::del("names");
>
> Redis::zadd("names", 100, "Farel");
> Redis::zadd("names", 100, "Farel");
> Redis::zadd("names", 85, "Mercys");
> Redis::zadd("names", 85, "Mercys");
> Redis::zadd("names", 95, "Thona");
> Redis::zadd("names", 95, "Thona");
>
> $response = Redis::zrange("names", 0, -1);
> self::assertEquals(["Mercys", "Thona", "Farel"], $response);
> ```
> #### HASH
> -
>
> berikut contoh kode hash :
> ```
> Redis::del("user:1");
>
> Redis::hset("user:1", "name", "Farel");
> Redis::hset("user:1", "email", "farel@localhost");
> Redis::hset("user:1", "age", 30);\
>
> $response = Redis::hgetall("user:1");
> self::assertEquals([
>     "name" => "Farel",
>     "email" => "farel@localhost",
>     "age" => "18"
> ], $response);
> ```
> #### GEO POINT
> -
>
> Berikut contoh salah satu kode geo point :
> ```
> Redis::del("sellers");
>
> Redis::geoadd("sellers", 106.820990, -6.174704, "Toko A");
> Redis::geoadd("sellers", 106.822696, -6.176870, "Toko B");
>
> $result = Redis::geodist("sellers", "Toko A", "Toko B", "km");
> self::assertEquals(0.3061, $result);
>
> $result = Redis::geosearch("sellers", new FromLonLat(106.821666, -6.175494), new ByRadius(5, "km"));
> self::assertEquals(["Toko A", "Toko B"], $result);
> }
> ```
>
> #### HYPER LOG LOG
> - 
>
> Berikut contoh kode partitioning :
> ```
> Redis::pfadd("visitors", "farel", "mercys", "putra");
> Redis::pfadd("visitors", "farel", "zeta", "takku");
> Redis::pfadd("visitors", "jasson", "zeta", "takku");
>
> $result = Redis::pfcount("visitors");
> self::assertEquals(6, $result);
> ```
>
> #### PIPELINE
> - Kita bisa menggunakan method pipeline(), dimana kita bisa tambahkan callback function yang berisi perintah perintah yang akan dikerjakan dalam pipeline tersebut
>
> Berikut contoh kode pipeline :
> ```
> Redis::pipeline(function ($pipeline){
>     $pipeline->setex("name", 2, "Farel");
>     $pipeline->setex("address", 2, "Indonesia");
> });
>
> $response = Redis::get("name");
> self::assertEquals("Farel", $response);
> $response = Redis::get("address");
> self::assertEquals("Indonesia", $response);
> ```
>
> #### TRANSACTION
> - Kita bisa menggunakan method transaction() dan cara penggunaannya sama seperti method pipeline()
>
> Berikut contoh kode transaction :
> ```
> Redis::transaction(function ($pipeline){
>     $transaction->setex("name", 2, "Farel");
>     $transaction->setex("address", 2, "Indonesia");
> });
>
> $response = Redis::get("name");
> self::assertEquals("Farel", $response);
> $response = Redis::get("address");
> self::assertEquals("Indonesia", $response);
> ```
>
> #### LARAVEL COMMAND
> - Untuk melakukan pengetesan subscriber, kita akan membuat laravel command yaitu fitur untuk membuat perintah berbasis terminal kitab isa gunakan perintah ```php artisan make:command NamaCommand```
>
> #### SUBSCRIBE PUBSUB
> - 
>
> Berikut contoh kode pubsub :
> ```
> for ($i = 0; $i < 10; $i++) {
>     Redis::publish("channel-1", "Hello World $i");
>     Redis::publish("channel-2", "Good Bye $i");
> }
> self::assertTrue(true);
> ```
>
> #### STREAM
> - 
>
> Berikut contoh kode stream :
> ```
> for ($i = 0; $i < 10; $i++) {
>     Redis::xadd("members", "*", [
>         "name" => "Farel $i",
>         "address" => "Indonesia"
>     ]);
> }
> self::assertTrue(true);
> ```
>
> #### CREATECONSUMER
>
> berikut contoh kode createcosumer :
> ```
> Redis::xgroup("create", "members", "group1", "0");
> Redis::xgroup("createconsumer", "members", "group1", "consumer-1");
> Redis::xgroup("createconsumer", "members", "group1", "consumer-2");
> self::assertTrue(true);
> ```
<p align="center" >
  <b>PERTANYAAN DAN CATATAN TAMBAHAN</b>
</p>

---

> - 

---

<p align="center" >
  <b>KESIMPULAN</b>
</p>


















