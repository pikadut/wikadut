
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
--- 04/06/2018
CREATE TABLE IF NOT EXISTS "public"."adm_project_list" (
  "id" serial8,
  "project_name" varchar(255),
  "description" varchar(255),
  "date_start" varchar(255),
  "date_end" varchar(255),
  PRIMARY KEY ("id")
)
;

CREATE OR REPLACE VIEW "public"."vw_adm_project_list" AS SELECT 
a."id" AS id,
a.project_name AS project_name,
a.description AS description,
concat(substr((a.date_start)::text,4,2),' ',
CASE COALESCE(substr((a.date_start)::TEXT,1,2))
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
        END, ' ', right((a.date_start)::text, 4)
) AS date_start,
concat(substr((a.date_end)::text,4,2),' ',CASE COALESCE(substr((a.date_end)::TEXT,1,2))
WHEN '01'::text THEN 'January'::text
WHEN '02'::text THEN 'February'::text
WHEN '03'::text THEN 'March'::text
WHEN '04'::text THEN 'April'::text
WHEN '05'::text THEN 'May'::text
WHEN '06'::text THEN 'June'::text
WHEN '07'::text THEN 'July'::text
WHEN '08'::text THEN 'August'::text
WHEN '09'::text THEN 'September'::text
WHEN '10'::text THEN 'October'::text
WHEN '11'::text THEN 'November'::text
WHEN '12'::text THEN 'December'::text
ELSE NULL::text
        END, ' ', right((a.date_end)::text, 4) 
) AS date_end,
CASE
WHEN (('now'::text)::date > to_date((a.date_end)::text, 'mm-dd-YYYY'::text)) THEN 'non-aktif'::text
WHEN (('now'::text)::date < to_date((a.date_end)::text, 'mm-dd-YYYY'::text)) THEN 'aktif'::text
ELSE NULL::text
END AS status
FROM adm_project_list a
;

--- 05/06/2018

DROP VIEW "public"."vw_adm_project_list";

CREATE VIEW "public"."vw_adm_project_list" AS  SELECT a.id,
    a.project_name,
    a.description,
    concat(substr((a.date_start)::text, 4, 2), ' ',
        CASE COALESCE(substr((a.date_start)::text, 1, 2))
            WHEN '01'::text THEN 'January'::text
            WHEN '02'::text THEN 'February'::text
            WHEN '03'::text THEN 'March'::text
            WHEN '04'::text THEN 'April'::text
            WHEN '05'::text THEN 'May'::text
            WHEN '06'::text THEN 'June'::text
            WHEN '07'::text THEN 'July'::text
            WHEN '08'::text THEN 'August'::text
            WHEN '09'::text THEN 'September'::text
            WHEN '10'::text THEN 'October'::text
            WHEN '11'::text THEN 'November'::text
            WHEN '12'::text THEN 'December'::text
            ELSE NULL::text
        END, ' ', "right"((a.date_start)::text, 4)) AS date_start,
    concat(substr((a.date_end)::text, 4, 2), ' ',
        CASE COALESCE(substr((a.date_end)::text, 1, 2))
            WHEN '01'::text THEN 'January'::text
            WHEN '02'::text THEN 'February'::text
            WHEN '03'::text THEN 'March'::text
            WHEN '04'::text THEN 'April'::text
            WHEN '05'::text THEN 'May'::text
            WHEN '06'::text THEN 'June'::text
            WHEN '07'::text THEN 'July'::text
            WHEN '08'::text THEN 'August'::text
            WHEN '09'::text THEN 'September'::text
            WHEN '10'::text THEN 'October'::text
            WHEN '11'::text THEN 'November'::text
            WHEN '12'::text THEN 'December'::text
            ELSE NULL::text
        END, ' ', "right"((a.date_end)::text, 4)) AS date_end,
        CASE
            WHEN (('now'::text)::date > to_date((a.date_end)::text, 'mm-dd-YYYY'::text)) THEN 'non-aktif'::text
            WHEN (('now'::text)::date < to_date((a.date_end)::text, 'mm-dd-YYYY'::text)) THEN 'aktif'::text
            ELSE NULL::text
        END AS status,
    a.disabled
   FROM adm_project_list a;

ALTER TABLE "public"."adm_project_list" 
  ADD COLUMN "disabled" int2;

-- blm di execute

ALTER TABLE "public"."prc_plan_main" 
  ADD COLUMN "ppm_type_of_plan" varchar(255),
  ADD COLUMN "ppm_project_name" varchar(255);
  ADD COLUMN "ppm_project_id" int4;

ALTER TABLE "public"."prc_plan_main" 
  ADD COLUMN "ppm_next_pos_id" int4;

ALTER TABLE "public"."prc_plan_comment" 
  ADD COLUMN "next_pos_id" int4;

--DROP VIEW "public"."vw_prc_plan_main";

CREATE OR REPLACE VIEW "public"."vw_prc_plan_main" AS  SELECT prc_plan_main.ppm_id,
    prc_plan_main.ppm_type_of_plan,
    prc_plan_main.ppm_project_name,
    prc_plan_main.ppm_subject_of_work,
    prc_plan_main.ppm_scope_of_work,
    prc_plan_main.ppm_district_id,
    prc_plan_main.ppm_district_name,
    prc_plan_main.ppm_dept_id,
    prc_plan_main.ppm_dept_name,
    prc_plan_main.ppm_planner,
    prc_plan_main.ppm_planner_pos_code,
    prc_plan_main.ppm_planner_pos_name,
    prc_plan_main.ppm_status,
        CASE COALESCE(prc_plan_main.ppm_status)
            WHEN 0 THEN 'Simpan Sementara'::text
            WHEN 1 THEN 'Belum Disetujui'::text
            WHEN 2 THEN 'Telah Disetujui User'::text
            WHEN 3 THEN concat('Telah Disetujui ', initcap((( SELECT vw_adm_pos.pos_name
               FROM vw_adm_pos
              WHERE (vw_adm_pos.pos_id = ( SELECT prc_plan_comment.pos_id
                       FROM prc_plan_comment
                      WHERE (prc_plan_comment.ppm_id = prc_plan_main.ppm_id)
                      ORDER BY prc_plan_comment.comment_id DESC
                     LIMIT 1))
             LIMIT 1))::text))
            WHEN 4 THEN 'Revisi'::text
            ELSE NULL::text
        END AS ppm_status_name,
    prc_plan_main.ppm_tender_method,
    prc_plan_main.ppm_contract_type,
    prc_plan_main.ppm_attachment1,
    prc_plan_main.ppm_attachment2,
    prc_plan_main.ppm_attachment3,
    prc_plan_main.ppm_attachment4,
    prc_plan_main.ppm_attachment5,
    prc_plan_main.ppm_mata_anggaran,
    prc_plan_main.ppm_nama_mata_anggaran,
    prc_plan_main.ppm_sub_mata_anggaran,
    prc_plan_main.ppm_nama_sub_mata_anggaran,
    prc_plan_main.ppm_pagu_anggaran,
    prc_plan_main.ppm_renc_kebutuhan,
    concat(
        CASE COALESCE("right"((prc_plan_main.ppm_renc_kebutuhan)::text, 2))
            WHEN '01'::text THEN 'January'::text
            WHEN '02'::text THEN 'February'::text
            WHEN '03'::text THEN 'March'::text
            WHEN '04'::text THEN 'April'::text
            WHEN '05'::text THEN 'May'::text
            WHEN '06'::text THEN 'June'::text
            WHEN '07'::text THEN 'July'::text
            WHEN '08'::text THEN 'August'::text
            WHEN '09'::text THEN 'September'::text
            WHEN '10'::text THEN 'October'::text
            WHEN '11'::text THEN 'November'::text
            WHEN '12'::text THEN 'December'::text
            ELSE NULL::text
        END, ' ', substr((prc_plan_main.ppm_renc_kebutuhan)::text, 1, 4)) AS ppm_renc_kebutuhan_vw,
    prc_plan_main.ppm_renc_pelaksanaan,
    concat(
        CASE COALESCE("right"((prc_plan_main.ppm_renc_pelaksanaan)::text, 2))
            WHEN '01'::text THEN 'January'::text
            WHEN '02'::text THEN 'February'::text
            WHEN '03'::text THEN 'March'::text
            WHEN '04'::text THEN 'April'::text
            WHEN '05'::text THEN 'May'::text
            WHEN '06'::text THEN 'June'::text
            WHEN '07'::text THEN 'July'::text
            WHEN '08'::text THEN 'August'::text
            WHEN '09'::text THEN 'September'::text
            WHEN '10'::text THEN 'October'::text
            WHEN '11'::text THEN 'November'::text
            WHEN '12'::text THEN 'December'::text
            ELSE NULL::text
        END, ' ', substr((prc_plan_main.ppm_renc_pelaksanaan)::text, 1, 4)) AS ppm_renc_pelaksanaan_vw,
    prc_plan_main.ppm_id_lokasi_pengiriman,
    prc_plan_main.ppm_lokasi_pengiriman,
    prc_plan_main.ppm_swakelola,
    prc_plan_main.ppm_sisa_anggaran,
    prc_plan_main.ppm_penata_perencanaan,
    prc_plan_main.ppm_pp_pos_code,
    prc_plan_main.ppm_pp_pos_name,
    prc_plan_main.ppm_currency,
    prc_plan_main.ppm_keterangan_tambahan,
    prc_plan_main.ppm_komentar,
    prc_plan_main.ppm_created_date,
    prc_plan_main.ppm_status_activity,
    prc_plan_main.ppm_ppn,
    prc_plan_main.ppm_kode_rencana,
    prc_plan_main.ppm_approved_date,
    prc_plan_main.ppm_approved_pos_code,
    prc_plan_main.ppm_approved_pos_name,
    prc_plan_main.ppm_planner_id,
    prc_plan_main.ppm_next_pos_id
   FROM prc_plan_main;