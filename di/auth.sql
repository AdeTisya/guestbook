/*
 Navicat Premium Dump SQL

 Source Server         : posgre17 Local
 Source Server Type    : PostgreSQL
 Source Server Version : 170005 (170005)
 Source Host           : localhost:5432
 Source Catalog        : manajementuser_db
 Source Schema         : auth

 Target Server Type    : PostgreSQL
 Target Server Version : 170005 (170005)
 File Encoding         : 65001

 Date: 28/08/2025 09:29:00
*/


-- ----------------------------
-- Sequence structure for ip_blocks_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "auth"."ip_blocks_id_seq";
CREATE SEQUENCE "auth"."ip_blocks_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for login_logs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "auth"."login_logs_id_seq";
CREATE SEQUENCE "auth"."login_logs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "auth"."users_id_seq";
CREATE SEQUENCE "auth"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Table structure for ip_blocks
-- ----------------------------
DROP TABLE IF EXISTS "auth"."ip_blocks";
CREATE TABLE "auth"."ip_blocks" (
  "id" int4 NOT NULL DEFAULT nextval('"auth".ip_blocks_id_seq'::regclass),
  "ip_address" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "reason" text COLLATE "pg_catalog"."default",
  "blocked_at" timestamptz(6) NOT NULL DEFAULT CURRENT_TIMESTAMP
)
;

-- ----------------------------
-- Records of ip_blocks
-- ----------------------------

-- ----------------------------
-- Table structure for login_logs
-- ----------------------------
DROP TABLE IF EXISTS "auth"."login_logs";
CREATE TABLE "auth"."login_logs" (
  "id" int8 NOT NULL DEFAULT nextval('"auth".login_logs_id_seq'::regclass),
  "user_id" int4,
  "ip_address" varchar(45) COLLATE "pg_catalog"."default" NOT NULL,
  "user_agent" text COLLATE "pg_catalog"."default",
  "login_at" timestamptz(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "is_success" bool NOT NULL,
  "credential_used" varchar(100) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Records of login_logs
-- ----------------------------
INSERT INTO "auth"."login_logs" VALUES (5, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 11:27:05.019914+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (6, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 11:30:51.324148+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (7, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:11:52.88583+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (8, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:12:04.824925+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (9, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:12:07.038618+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (10, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:12:07.506372+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (11, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:12:08.862601+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (12, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:12:23.162914+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (13, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-04 15:39:34.997287+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (14, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-06 10:43:42.310307+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (15, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-06 10:52:22.933737+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (16, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-06 10:53:04.444129+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (17, 1, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-08-06 11:18:08.684221+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (18, 1, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-08-06 11:19:00.514399+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (19, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-06 11:47:46.970529+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (20, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 01:31:01.354182+07', 'f', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (21, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 01:31:08.074097+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (22, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 02:38:51.012383+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (23, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 03:38:08.138917+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (24, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 08:09:44.51368+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (25, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-11 10:16:10.874282+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (26, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-12 09:14:29.387143+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (27, 1, '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', '2025-08-12 15:18:36.026674+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (28, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-12 15:25:40.762024+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (29, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-12 15:38:05.176448+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (30, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 08:19:23.681358+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (31, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 11:03:01.759736+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (32, 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-13 11:10:19.634506+07', 't', 'adetisya@gmail.com');
INSERT INTO "auth"."login_logs" VALUES (33, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:40:28.501813+07', 't', 'admin@kominfogunungkidul.com');
INSERT INTO "auth"."login_logs" VALUES (34, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 11:42:47.314226+07', 't', 'admin@kominfogunungkidul.com');
INSERT INTO "auth"."login_logs" VALUES (35, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 15:52:47.891594+07', 'f', 'admin@kominfogunungkidul.com');
INSERT INTO "auth"."login_logs" VALUES (36, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-14 15:52:58.525648+07', 't', 'admin@kominfogunungkidul.com');
INSERT INTO "auth"."login_logs" VALUES (37, 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-08-15 08:28:53.362657+07', 't', 'admin@kominfogunungkidul.com');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "auth"."users";
CREATE TABLE "auth"."users" (
  "id" int4 NOT NULL DEFAULT nextval('"auth".users_id_seq'::regclass),
  "username" varchar(30) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "password_hash" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "nama_lengkap" varchar(100) COLLATE "pg_catalog"."default",
  "is_active" bool DEFAULT true,
  "created_at" timestamptz(6) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  "updated_at" timestamptz(6),
  "is_aktif" int2
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "auth"."users" VALUES (1, 'ade', 'adetisya@gmail.com', '$2y$10$s49Y5mM8S9M5nvJdCGKkI.9we/O5zRmM8wOdEa50Z9bY0gp4g.NZ2', 'adetisya', 't', '2025-08-01 14:36:32+07', '2025-08-01 14:36:37+07', 1);
INSERT INTO "auth"."users" VALUES (2, 'admin', 'admin@kominfogunungkidul.com', '$2y$10$DucKmC4lbT.TTOD7fHlRfeSowceH9beU3DJ3z1bF72joyFuUReqt.', 'Administrator', 't', '2025-08-14 11:36:10.283291+07', '2025-08-14 11:36:10.283291+07', 1);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "auth"."ip_blocks_id_seq"
OWNED BY "auth"."ip_blocks"."id";
SELECT setval('"auth"."ip_blocks_id_seq"', 1, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "auth"."login_logs_id_seq"
OWNED BY "auth"."login_logs"."id";
SELECT setval('"auth"."login_logs_id_seq"', 37, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "auth"."users_id_seq"
OWNED BY "auth"."users"."id";
SELECT setval('"auth"."users_id_seq"', 2, true);

-- ----------------------------
-- Uniques structure for table ip_blocks
-- ----------------------------
ALTER TABLE "auth"."ip_blocks" ADD CONSTRAINT "ip_blocks_ip_address_key" UNIQUE ("ip_address");

-- ----------------------------
-- Primary Key structure for table ip_blocks
-- ----------------------------
ALTER TABLE "auth"."ip_blocks" ADD CONSTRAINT "ip_blocks_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table login_logs
-- ----------------------------
ALTER TABLE "auth"."login_logs" ADD CONSTRAINT "login_logs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "auth"."users" ADD CONSTRAINT "users_username_key" UNIQUE ("username");
ALTER TABLE "auth"."users" ADD CONSTRAINT "users_email_key" UNIQUE ("email");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "auth"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table login_logs
-- ----------------------------
ALTER TABLE "auth"."login_logs" ADD CONSTRAINT "login_logs_user_id_fkey" FOREIGN KEY ("user_id") REFERENCES "auth"."users" ("id") ON DELETE SET NULL ON UPDATE NO ACTION;
