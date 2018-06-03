
-- 27/05/2018
CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_5" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id")
)
;

---
CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_5" AS 
SELECT DISTINCT
	adm_auth_hie_5.pos_id AS hap_pos_code,
	
adm_pos.pos_name AS hap_pos_name,
	
A.pos_id AS hap_pos_parent,
	
adm_auth_hie_5.max_amount AS hap_amount,
	
adm_auth_hie_5.currency AS hap_currency,
	
adm_pos.district_id AS hap_district,
	
adm_pos_1.pos_name AS hap_pos_parent_name 
FROM
	
(((
	adm_auth_hie_5
	LEFT JOIN adm_pos ON 
((
	adm_auth_hie_5.pos_id = adm_pos.pos_id 
	
)))
	LEFT JOIN adm_auth_hie_5 A 
ON ((
	adm_auth_hie_5.parent_id = A.auth_hie_id 
	)))
	
LEFT JOIN adm_pos adm_pos_1 ON ((
	A.pos_id = adm_pos_1.pos_id 
	))) 

ORDER BY
	adm_auth_hie_5.pos_id;


-- 01/06/2018

CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_6" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));


CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_7" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));

CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_8" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));

CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_9" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));

CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_10" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));

CREATE TABLE IF NOT EXISTS "public"."adm_auth_hie_11" (
  "auth_hie_id" int4 NOT NULL DEFAULT nextval('adm_auth_hie_auth_hie_id_seq'::regclass),
  "pos_id" int4,
  "max_amount" numeric(19,4),
  "currency" char(4) COLLATE "pg_catalog"."default",
  "parent_id" int4,
  PRIMARY KEY ("auth_hie_id"));

CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_6" AS  SELECT DISTINCT adm_auth_hie_6.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_6.max_amount AS hap_amount,
    adm_auth_hie_6.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_6
     LEFT JOIN adm_pos ON ((adm_auth_hie_6.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_6 a ON ((adm_auth_hie_6.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_6.pos_id;

CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_7" AS  SELECT DISTINCT adm_auth_hie_7.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_7.max_amount AS hap_amount,
    adm_auth_hie_7.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_7
     LEFT JOIN adm_pos ON ((adm_auth_hie_7.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_7 a ON ((adm_auth_hie_7.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_7.pos_id;

CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_8" AS  SELECT DISTINCT adm_auth_hie_8.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_8.max_amount AS hap_amount,
    adm_auth_hie_8.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_8
     LEFT JOIN adm_pos ON ((adm_auth_hie_8.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_8 a ON ((adm_auth_hie_8.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_8.pos_id;

CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_9" AS  SELECT DISTINCT adm_auth_hie_9.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_9.max_amount AS hap_amount,
    adm_auth_hie_9.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_9
     LEFT JOIN adm_pos ON ((adm_auth_hie_9.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_9 a ON ((adm_auth_hie_9.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_9.pos_id;

CREATE OR REPLACE VIEW"public"."vw_prc_hierarchy_approval_10" AS  SELECT DISTINCT adm_auth_hie_10.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_10.max_amount AS hap_amount,
    adm_auth_hie_10.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_10
     LEFT JOIN adm_pos ON ((adm_auth_hie_10.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_10 a ON ((adm_auth_hie_10.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_10.pos_id;

CREATE OR REPLACE VIEW "public"."vw_prc_hierarchy_approval_11" AS  SELECT DISTINCT adm_auth_hie_11.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    a.pos_id AS hap_pos_parent,
    adm_auth_hie_11.max_amount AS hap_amount,
    adm_auth_hie_11.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_11
     LEFT JOIN adm_pos ON ((adm_auth_hie_11.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_11 a ON ((adm_auth_hie_11.parent_id = a.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_11.pos_id;

CREATE TABLE IF NOT EXISTS "public"."adm_hierarchy_menu" (
  "id" int4 NOT NULL,
  "title" varchar(255) NOT NULL,
  "url" varchar(255) NOT NULL
)
;