<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Predis\Command\Argument\Geospatial\ByRadius;
use Predis\Command\Argument\Geospatial\FromLonLat;
use Tests\TestCase;


class RedisTest extends TestCase
{
    public function testPing()
    {
        $response = Redis::command("ping");
        self::assertEquals("PONG", $response);

        $response = Redis::ping();
        self::assertEquals("PONG", $response);
    }

    public function testString()
    {
        Redis::setex("name", 2, "Farel");
        $response = Redis::get("name");
        self::assertEquals("Farel", $response);

        sleep(5);

        $response = Redis::get("name");
        self::assertNull($response);
    }

    public function testList()
    {
        Redis::del("names");

        Redis::rpush("names", "Farel");
        Redis::rpush("names", "Mercys");
        Redis::rpush("names", "Thona");

        $response = Redis::lrange("names", 0, -1);
        self::assertEquals(["Farel", "Mercys", "Thona"], $response);

        self::assertEquals("Farel", Redis::lpop("names"));
        self::assertEquals("Mercys", Redis::lpop("names"));
        self::assertEquals("Thona", Redis::lpop("names"));

    }

    public function testSet()
    {
        Redis::del("names");

        Redis::sadd("names", "Farel");
        Redis::sadd("names", "Farel");
        Redis::sadd("names", "Mercys");
        Redis::sadd("names", "Mercys");
        Redis::sadd("names", "Thona");
        Redis::sadd("names", "Thona");

        $response = Redis::smembers("names");
        self::assertEquals(["Farel", "Mercys", "Thona"], $response);
    }

    public function testSortedSet()
    {

        Redis::del("names");

        Redis::zadd("names", 100, "Farel");
        Redis::zadd("names", 100, "Farel");
        Redis::zadd("names", 85, "Mercys");
        Redis::zadd("names", 85, "Mercys");
        Redis::zadd("names", 95, "Thona");
        Redis::zadd("names", 95, "Thona");

        $response = Redis::zrange("names", 0, -1);
        self::assertEquals(["Mercys", "Thona", "Farel"], $response);
    }

    public function testHash()
    {
        Redis::del("user:1");

        Redis::hset("user:1", "name", "Farel");
        Redis::hset("user:1", "email", "farel@localhost");
        Redis::hset("user:1", "age", 30);

        $response = Redis::hgetall("user:1");
        self::assertEquals([
            "name" => "Farel",
            "email" => "farel@localhost",
            "age" => "18"
        ], $response);
    }


}
