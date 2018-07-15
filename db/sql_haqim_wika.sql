
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

--28/06/2018
ALTER TABLE "public"."prc_tender_vendor" 
  ALTER COLUMN "ptv_is_attend_2" SET DEFAULT 0;

ALTER TABLE "public"."prc_tender_quo_main_hist" 
  ALTER COLUMN "pqm_guarantee_unit" TYPE varchar(32) USING "pqm_guarantee_unit"::varchar(32),
  ALTER COLUMN "pqm_deliverable_unit" TYPE varchar(32) USING "pqm_deliverable_unit"::varchar(32);


DROP VIEW "public"."vw_prc_evaluation";

CREATE VIEW "public"."vw_prc_evaluation" AS  SELECT prc_tender_eval.ptm_number,
    prc_tender_eval.ptv_vendor_code,
    vw_vendor.lkp_description AS vendor_name,
        CASE
            WHEN (prc_tender_vendor_status.pvs_technical_status = 1) THEN 'Lulus'::text
            ELSE 'Tidak Lulus'::text
        END AS adm,
    COALESCE(prc_tender_eval.pte_technical_value, (0)::double precision) AS pte_technical_value,
    prc_tender_eval.pte_passing_grade,
        CASE
            WHEN (prc_tender_eval.pte_technical_value IS NULL) THEN '-'::text
            WHEN (COALESCE(prc_tender_eval.pte_technical_value, (0)::double precision) >= prc_tender_eval.pte_passing_grade) THEN 'Lulus'::text
            ELSE 'Tidak Lulus'::text
        END AS pass,
    prc_tender_eval.pte_technical_remark,
    COALESCE(prc_tender_eval.pte_price_value, (0)::double precision) AS pte_price_value,
    COALESCE(((prc_tender_eval.pte_technical_weight * prc_tender_eval.pte_technical_value) / (100)::double precision), (0)::double precision) AS pte_technical_weight,
        CASE
            WHEN ((vnd_header.npwp_pkp)::text = 'YA'::text) THEN (tqi.amount * 1.1)
            ELSE tqi.amount
        END AS amount,
    COALESCE(((prc_tender_eval.pte_price_weight * prc_tender_eval.pte_price_value) / (100)::double precision), (0)::double precision) AS pte_price_weight,
    (COALESCE(((prc_tender_eval.pte_technical_weight * prc_tender_eval.pte_technical_value) / (100)::double precision), (0)::double precision) + COALESCE(((prc_tender_eval.pte_price_weight * prc_tender_eval.pte_price_value) / (100)::double precision), (0)::double precision)) AS total,
    prc_tender_eval.pte_price_remark,
    prc_tender_vendor_status.pvs_status,
    prc_tender_vendor_status.pvs_is_winner,
    prc_tender_vendor_status.pvs_is_negotiate,
    prc_tender_eval.pte_validity_offer,
    prc_tender_eval.pte_validity_bid_bond,
    ptqm.pqm_id,
		ptqm.pqm_type AS pqm_type,(case when ((coalesce(prc_tender_eval.pte_validity_offer,0) <> 0) and (coalesce(prc_tender_eval.pte_validity_bid_bond,0) <> 0)) then 'Lulus' when (prc_tender_eval.pte_validity_offer IS NULL or prc_tender_eval.pte_validity_bid_bond IS NULL) then '' else 'Tidak Lulus' end) AS pass_price
   FROM (((((vw_vendor
     LEFT JOIN prc_tender_eval ON ((vw_vendor.lkp_id = prc_tender_eval.ptv_vendor_code)))
     LEFT JOIN prc_tender_vendor_status ON ((((prc_tender_vendor_status.ptm_number)::text = (prc_tender_eval.ptm_number)::text) AND (prc_tender_vendor_status.pvs_vendor_code = prc_tender_eval.ptv_vendor_code))))
     LEFT JOIN prc_tender_quo_main ptqm ON ((((ptqm.ptm_number)::text = (prc_tender_eval.ptm_number)::text) AND (ptqm.ptv_vendor_code = prc_tender_eval.ptv_vendor_code))))
     LEFT JOIN ( SELECT ptqm1.ptm_number,
            ptqm1.ptv_vendor_code,
            sum(((vw_prc_quotation_item.pqi_quantity)::numeric * vw_prc_quotation_item.pqi_price)) AS amount
           FROM (vw_prc_quotation_item
             JOIN prc_tender_quo_main ptqm1 ON ((vw_prc_quotation_item.pqm_id = ptqm1.pqm_id)))
          GROUP BY ptqm1.ptm_number, ptqm1.ptv_vendor_code) tqi ON ((((tqi.ptm_number)::text = (prc_tender_vendor_status.ptm_number)::text) AND (tqi.ptv_vendor_code = prc_tender_eval.ptv_vendor_code))))
     JOIN vnd_header ON ((vnd_header.vendor_id = prc_tender_eval.ptv_vendor_code)))
  ORDER BY ptqm.ptm_number, ptqm.pqm_type, ptqm.ptv_vendor_code;


DROP VIEW "public"."vw_prc_tender_quo_tech";

CREATE VIEW "public"."vw_prc_tender_quo_tech" AS  SELECT pqt.pqt_id,
    pqt.pqt_item,
    pqt.pqt_weight,
    pqt.pqt_check,
    pqt.pqt_check_vendor,
    pqt.pqt_vendor_desc,
    pqt.pqt_value,
		pqt.pqt_attachment,
    pqm.pqm_id,
    pqm.ptm_number,
    pqm.ptv_vendor_code,
    pqm.pqm_number,
    pqm.pqm_type,
    pqm.pqm_bid_bond_value,
    pqm.pqm_local_content,
    pqm.pqm_delivery_time,
    pqm.pqm_delivery_unit,
    pqm.pqm_valid_thru,
    pqm.pqm_notes,
    pqm.pqm_att,
    pqm.pqm_created_date,
    pqm.pqm_currency,
    vnd.vendor_name,
    ptvs.pvs_status,
    ptvs.pvs_technical_status
   FROM (((prc_tender_quo_tech pqt
     JOIN prc_tender_quo_main pqm ON ((pqm.pqm_id = pqt.pqm_id)))
     JOIN vnd_header vnd ON ((pqm.ptv_vendor_code = vnd.vendor_id)))
     JOIN prc_tender_vendor_status ptvs ON ((((pqm.ptm_number)::text = (ptvs.ptm_number)::text) AND (pqm.ptv_vendor_code = ptvs.pvs_vendor_code))));

DROP VIEW "public"."vw_prc_quotation_item"; --CASCADE create kembali vw_prc_evaluation

CREATE VIEW "public"."vw_prc_quotation_item" AS  SELECT prc_tender_item.tit_code,
    prc_tender_quo_item.pqm_id,
    prc_tender_item.tit_description,
    prc_tender_item.tit_quantity,
    prc_tender_item.tit_unit,
    prc_tender_quo_item.pqi_description,
    COALESCE((prc_tender_quo_item.pqi_quantity)::double precision, prc_tender_item.tit_quantity) AS pqi_quantity,
    prc_tender_quo_item.pqi_price,
		prc_tender_quo_item.pqi_ppn,
		prc_tender_quo_item.pqi_pph,
		prc_tender_quo_item.pqi_guarantee,
		prc_tender_quo_item.pqi_guarantee_type,
		prc_tender_quo_item.pqi_deliverable,
		prc_tender_quo_item.pqi_deliverable_type,
    prc_tender_item.tit_id,
    vnd_header.vendor_name,
    prc_tender_quo_main.ptm_number,
    prc_tender_quo_main.ptv_vendor_code,
    vw_com_catalog.last_price AS catalog_price,
    vw_com_catalog.short_description,
    vw_com_catalog.long_description,
    prc_tender_item.tit_price,
    vnd_header.vendor_id,
    vw_com_catalog.catalog_type
   FROM ((((prc_tender_quo_item
     JOIN prc_tender_item ON ((prc_tender_quo_item.tit_id = prc_tender_item.tit_id)))
     JOIN prc_tender_quo_main ON ((prc_tender_quo_main.pqm_id = prc_tender_quo_item.pqm_id)))
     JOIN vnd_header ON ((vnd_header.vendor_id = prc_tender_quo_main.ptv_vendor_code)))
     LEFT JOIN vw_com_catalog ON (((prc_tender_item.tit_code)::text = (vw_com_catalog.catalog_code)::text)));

---02/07/2018
ALTER TABLE adm_auth_hie_5
RENAME TO adm_auth_hie_rkp;

ALTER TABLE adm_auth_hie_6
RENAME TO adm_auth_hie_rkap;

ALTER TABLE adm_auth_hie_7
RENAME TO adm_auth_hie_pr_proyek;

ALTER TABLE adm_auth_hie
RENAME TO adm_auth_hie_pr_non_proyek;

ALTER TABLE adm_auth_hie_8
RENAME TO adm_auth_hie_rfq_proyek;

ALTER TABLE adm_auth_hie_2
RENAME TO adm_auth_hie_rfq_non_proyek;

ALTER TABLE adm_auth_hie_9
RENAME TO adm_auth_hie_pemenang_proyek;

ALTER TABLE adm_auth_hie_3
RENAME TO adm_auth_hie_pemenang_non_proyek;

ALTER TABLE adm_auth_hie_10
RENAME TO adm_auth_hie_kontrak_proyek;

ALTER TABLE adm_auth_hie_11
RENAME TO adm_auth_hie_kontrak_non_proyek;

--- 03/07/2018

DROP VIEW "public"."vw_daftar_pekerjaan_sppbj";

CREATE VIEW "public"."vw_daftar_pekerjaan_sppbj" AS  SELECT prc_pr_main.pr_number,
    prc_pr_main."isSwakelola",
    prc_pr_main.pr_requester_name,
    prc_pr_main.pr_requester_pos_code,
    prc_pr_main.pr_requester_pos_name,
    prc_pr_main.pr_created_date,
    prc_pr_main.pr_subject_of_work,
    prc_pr_main.pr_scope_of_work,
    prc_pr_main.pr_district_id,
    prc_pr_main.pr_district AS pr_district_name,
    prc_pr_main.pr_delivery_point_id,
    prc_pr_main.pr_delivery_point,
    prc_pr_main.pr_delivery_time,
    prc_pr_main.pr_delivery_unit,
    prc_pr_main.pr_buyer,
    prc_pr_main.pr_buyer_pos_code,
    prc_pr_main.pr_buyer_pos_name,
    prc_pr_main.pr_currency,
    prc_pr_main.pr_contract_type,
    prc_pr_main.pr_last_participant,
    prc_pr_main.pr_last_participant_code,
    prc_pr_main.pr_status,
    prc_pr_main.pr_dept_id,
    prc_pr_main.pr_dept_name,
    prc_pr_main.pr_mata_anggaran,
    prc_pr_main.pr_nama_mata_anggaran,
    prc_pr_main.pr_sub_mata_anggaran,
    prc_pr_main.pr_nama_sub_mata_anggaran,
    prc_pr_main.pr_pagu_anggaran,
    prc_pr_main.pr_sisa_anggaran,
    prc_pr_main.pr_requester_id,
    prc_pr_main.ppm_id,
    prc_pr_main.pr_type,
    COALESCE(( SELECT adm_wkf_activity.awa_name
           FROM adm_wkf_activity
          WHERE (adm_wkf_activity.awa_id = ( SELECT prc_pr_comment.ppc_activity
                   FROM prc_pr_comment
                  WHERE (((prc_pr_comment.pr_number)::text = (prc_pr_main.pr_number)::text) AND (prc_pr_comment.ppc_name IS NULL))))), 'Permintaan dilanjutkan ke RFQ-Undangan'::character varying) AS status,
    COALESCE((( SELECT format((sum(((prc_pr_item.ppi_quantity * (prc_pr_item.ppi_price)::double precision) * (1.1)::double precision)))::text, 2) AS jumlah
           FROM prc_pr_item
          WHERE ((prc_pr_item.pr_number)::text = (prc_pr_main.pr_number)::text)
          GROUP BY prc_pr_item.pr_number))::double precision, (0)::double precision) AS nilai,
		prc_pr_main.pr_project_name,
		prc_pr_main.pr_type_of_plan
   FROM prc_pr_main;


DROP VIEW "public"."vw_prc_pr_monitor";

CREATE VIEW "public"."vw_prc_pr_monitor" AS  SELECT pr.pr_number,
    pr."isSwakelola",
    pr.pr_requester_name,
    pr.pr_requester_pos_code,
    pr.pr_requester_pos_name,
    pr.pr_created_date,
    pr.pr_subject_of_work,
    pr.pr_scope_of_work,
    pr.pr_district_id,
    pr.pr_district,
    pr.pr_delivery_point_id,
    pr.pr_delivery_point,
    pr.pr_delivery_time,
    pr.pr_delivery_unit,
    pr.pr_buyer,
    pr.pr_buyer_pos_code,
    pr.pr_buyer_pos_name,
    pr.pr_currency,
    pr.pr_contract_type,
    pr.pr_last_participant,
    pr.pr_last_participant_code,
    pr.pr_status,
    pr.pr_dept_id,
    pr.pr_dept_name,
    pr.pr_mata_anggaran,
    pr.pr_nama_mata_anggaran,
    pr.pr_sub_mata_anggaran,
    pr.pr_nama_sub_mata_anggaran,
    pr.pr_pagu_anggaran,
    pr.pr_sisa_anggaran,
    pr.pr_requester_id,
    pr.ppm_id,
    pr.pr_type,
    ( SELECT adm_wkf_activity.awa_name
           FROM adm_wkf_activity
          WHERE (adm_wkf_activity.awa_id = ( SELECT ppc.ppc_activity
                   FROM prc_pr_comment ppc
                  WHERE ((ppc.pr_number)::text = (pr.pr_number)::text)
                  ORDER BY ppc.ppc_id DESC
                 LIMIT 1))) AS status,
    ( SELECT ppc.ppc_activity
           FROM prc_pr_comment ppc
          WHERE (((ppc.pr_number)::text = (pr.pr_number)::text) AND (ppc.ppc_name IS NOT NULL))
          ORDER BY ppc.ppc_id DESC
         LIMIT 1) AS last_status,
    ( SELECT ppc.ppc_position
           FROM prc_pr_comment ppc
          WHERE (((ppc.pr_number)::text = (pr.pr_number)::text) AND (ppc.ppc_name IS NOT NULL))
          ORDER BY ppc.ppc_id DESC
         LIMIT 1) AS last_pos,
		pr.pr_project_name,
    pr.pr_type_of_plan
   FROM prc_pr_main pr;

COMMENT ON VIEW "public"."vw_prc_pr_monitor" IS 'Monitor PR';


ALTER TABLE "public"."prc_tender_main" 
  ADD COLUMN "pr_type" varchar(255),
  ADD COLUMN "ptm_type_of_plan" varchar(255),
  ADD COLUMN "ptm_project_name" varchar(255);

--06/07/2018
CREATE OR REPLACE VIEW "public"."vw_prc_monitor" AS  SELECT ptm.pr_number,
    ptp.ptm_number,
    vnd.vendor_name,
    vnd.vendor_id,
    ptm.ptm_upreff,
    ptm.ptm_downreff,
    ptm.ptm_requester_name,
    ptm.ptm_requester_pos_code,
    ptm.ptm_requester_pos_name,
    ptm.ptm_created_date,
    ptm.ptm_subject_of_work,
    ptm.ptm_scope_of_work,
    ptm.ptm_district_id,
    ptm.ptm_district,
    ptm.ptm_delivery_point_id,
    ptm.ptm_delivery_point,
    ptm.ptm_delivery_time,
    ptm.ptm_delivery_unit,
    ptm.ptm_buyer,
    ptm.ptm_buyer_pos_code,
    ptm.ptm_buyer_pos_name,
    ptm.ptm_currency,
    ptm.ptm_contract_type,
    ptm.ptm_last_participant,
    ptm.ptm_last_participant_code,
    ptm.ptm_is_contract_created,
    ptm.ptm_rfq_no,
    ptm.ptm_status,
    ptm.ptm_completed_date,
    ptm.ptm_tender_id,
    ptm.ptm_is_manual,
    ptm.ptm_dept_id,
    ptm.ptm_dept_name,
    ptm.ptm_mata_anggaran,
    ptm.ptm_nama_mata_anggaran,
    ptm.ptm_sub_mata_anggaran,
    ptm.ptm_nama_sub_mata_anggaran,
    ptm.ptm_pagu_anggaran,
    ptm.ptm_sisa_anggaran,
    ptm.ptm_requester_id,
    ptp.ptp_id,
    ptp.ptp_tender_method,
    ptp.ptp_submission_method,
    ptp.ptp_evaluation_method,
    ptp.ptp_reg_opening_date,
    ptp.ptp_reg_closing_date,
    ptp.ptp_prebid_date,
    ptp.ptp_prebid_location,
    ptp.ptp_quot_closing_date,
    ptp.ptp_tech_bid_date,
    ptp.ptp_quot_opening_date,
    ptp.ptp_eauction,
    ptp.ptp_inquiry_notes,
    ptp.ptp_enabled_rank,
    ptp.ptp_prequalify,
    ptp.ptp_doc_open_date,
    ptp.ptp_preq_info,
    ptp.evt_id,
    ptp.evt_description,
    ptp.adm_bid_committee,
    ptp.adm_bid_committee_name,
    ptp.ppt_id,
    ptp.ppt_name,
    ptp.ptp_bid_opening2,
    ptp.ptp_tgl_aanwijzing2,
    ptp.ptp_lokasi_aanwijzing2,
    ptp.ptp_klasifikasi_peserta,
    ptp.ptp_aanwijzing_online,
    ( SELECT adm_wkf_activity.awa_name
           FROM adm_wkf_activity
          WHERE (adm_wkf_activity.awa_id = ( SELECT ptc.ptc_activity
                   FROM prc_tender_comment ptc
                  WHERE ((ptc.ptm_number)::text = (ptm.ptm_number)::text)
                  ORDER BY ptc.ptc_id DESC
                 LIMIT 1))) AS status,
    pqvs.total AS total_contract,
    COALESCE(( SELECT ptc.ptc_activity
           FROM prc_tender_comment ptc
          WHERE ((ptc.ptm_number)::text = (ptm.ptm_number)::text)
          ORDER BY ptc.ptc_id DESC
         LIMIT 1), ptm.ptm_status) AS last_status,
    ( SELECT ptc.ptc_position
           FROM prc_tender_comment ptc
          WHERE ((ptc.ptm_number)::text = (ptm.ptm_number)::text)
          ORDER BY ptc.ptc_id DESC
         LIMIT 1) AS last_pos,
    pqm.pqm_currency,
		ptm.pr_type,
		ptm.ptm_type_of_plan,
		ptm.ptm_project_name
   FROM (((((prc_tender_main ptm
     LEFT JOIN prc_tender_prep ptp ON (((ptp.ptm_number)::text = (ptm.ptm_number)::text)))
     LEFT JOIN prc_tender_vendor_status ptvs ON ((((ptvs.ptm_number)::text = (ptm.ptm_number)::text) AND (ptvs.pvs_is_winner = 1))))
     LEFT JOIN vnd_header vnd ON ((vnd.vendor_id = ptvs.pvs_vendor_code)))
     LEFT JOIN prc_tender_quo_main pqm ON (((vnd.vendor_id = pqm.ptv_vendor_code) AND ((ptp.ptm_number)::text = (pqm.ptm_number)::text))))
     LEFT JOIN vw_prc_quotation_vendor_sum pqvs ON (((vnd.vendor_id = pqvs.ptv_vendor_code) AND ((pqvs.ptm_number)::text = (ptm.ptm_number)::text))));

---13/07/2018
ALTER TABLE "public"."com_mat_price" 
  ALTER COLUMN "del_point_id" DROP NOT NULL;

DROP VIEW "public"."vw_daftar_pekerjaan_rfq";

CREATE VIEW "public"."vw_daftar_pekerjaan_rfq" AS  SELECT a.ptc_id,
    a.ptm_number,
    a.ptc_user,
    b.ptm_buyer_id,
    b.ptm_requester_name,
    b.ptm_subject_of_work,
    b.ptm_delivery_point,
    b.ptm_requester_pos_name,
    b.ptm_status,
    c.awa_name AS activity,
    to_char(a.ptc_start_date, 'YYYY-MM-DD HH24:MI:SS') AS waktu,
    a.ptc_pos_code,
        CASE b.ptm_type_of_plan
            WHEN 'rkp'::text THEN 'Proyek'::text
            ELSE 'Non Proyek'::text
        END AS jenis_pengadaan
   FROM ((prc_tender_comment a
     LEFT JOIN prc_tender_main b ON (((b.ptm_number)::text = (a.ptm_number)::text)))
     LEFT JOIN adm_wkf_activity c ON ((c.awa_id = a.ptc_activity)))
  WHERE ((a.ptc_name IS NULL) AND (a.ptc_end_date IS NULL) AND (a.ptc_activity <> ALL (ARRAY[1901, 1903])));

-- 14/07/2018

CREATE OR REPLACE VIEW "public"."vw_daftar_pekerjaan_pr" AS  SELECT a.pr_number,
    c.awa_name,
    b.pr_subject_of_work,
    b.pr_requester_name,
    b.pr_requester_pos_name,
    a.ppc_start_date,
		a.ppc_start_date as waktu,
    b.pr_status,
    a.ppc_pos_code,
    b.pr_type_of_plan,
    a.ppc_id,
    a.ppc_activity,
        CASE b.pr_type_of_plan
            WHEN 'rkp'::text THEN 'Proyek'::text
            ELSE 'Non Proyek'::text
        END AS jenis_pengadaan
   FROM ((prc_pr_comment a
     LEFT JOIN prc_pr_main b ON (((b.pr_number)::text = (a.pr_number)::text)))
     LEFT JOIN adm_wkf_activity c ON ((c.awa_id = a.ppc_activity)))
  WHERE ((a.ppc_name IS NULL) AND (a.ppc_end_date IS NULL) AND (a.ppc_activity <> 1904));

-- blm dipush
-- 15/07/2018

DROP VIEW "public"."vw_prc_hierarchy_approval";

CREATE VIEW "public"."vw_prc_hierarchy_approval" AS --  SELECT adm_auth_hie_pr_non_proyek.pos_id AS hap_pos_code,
--     adm_pos.pos_name AS hap_pos_name,
--     adm_auth_hie_1.pos_id AS hap_pos_parent,
--     adm_auth_hie_pr_non_proyek.max_amount AS hap_amount,
--     adm_auth_hie_pr_non_proyek.currency AS hap_currency,
--     adm_pos.district_id AS hap_district,
--     adm_pos_1.pos_name AS hap_pos_parent_name
--    FROM (((adm_auth_hie_pr_non_proyek
--      JOIN adm_pos ON ((adm_auth_hie_pr_non_proyek.pos_id = adm_pos.pos_id)))
--      JOIN adm_auth_hie_pr_non_proyek adm_auth_hie_1 ON ((adm_auth_hie_pr_non_proyek.parent_id = adm_auth_hie_1.auth_hie_id)))
--      JOIN adm_pos adm_pos_1 ON ((adm_auth_hie_1.pos_id = adm_pos_1.pos_id)))
--   ORDER BY adm_auth_hie_pr_non_proyek.pos_id
-- 	

SELECT DISTINCT adm_auth_hie_pr_non_proyek.pos_id AS hap_pos_code,
    adm_pos.pos_name AS hap_pos_name,
    adm_auth_hie_1.pos_id AS hap_pos_parent,
    adm_auth_hie_pr_non_proyek.max_amount AS hap_amount,
    adm_auth_hie_pr_non_proyek.currency AS hap_currency,
    adm_pos.district_id AS hap_district,
    adm_pos_1.pos_name AS hap_pos_parent_name
   FROM (((adm_auth_hie_pr_non_proyek
     LEFT JOIN adm_pos ON ((adm_auth_hie_pr_non_proyek.pos_id = adm_pos.pos_id)))
     LEFT JOIN adm_auth_hie_pr_non_proyek adm_auth_hie_1 ON ((adm_auth_hie_pr_non_proyek.parent_id = adm_auth_hie_1.auth_hie_id)))
     LEFT JOIN adm_pos adm_pos_1 ON ((adm_auth_hie_1.pos_id = adm_pos_1.pos_id)))
  ORDER BY adm_auth_hie_pr_non_proyek.pos_id;
