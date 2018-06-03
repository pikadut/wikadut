CREATE OR REPLACE VIEW public.vw_prc_monitor AS
select ptm.pr_number AS pr_number,ptp.ptm_number AS ptm_number,vnd.vendor_name AS vendor_name,vnd.vendor_id AS vendor_id,ptm.ptm_upreff AS ptm_upreff,ptm.ptm_downreff AS ptm_downreff,ptm.ptm_requester_name AS ptm_requester_name,ptm.ptm_requester_pos_code AS ptm_requester_pos_code,ptm.ptm_requester_pos_name AS ptm_requester_pos_name,ptm.ptm_created_date AS ptm_created_date,ptm.ptm_subject_of_work AS ptm_subject_of_work,ptm.ptm_scope_of_work AS ptm_scope_of_work,ptm.ptm_district_id AS ptm_district_id,ptm.ptm_district AS ptm_district,ptm.ptm_delivery_point_id AS ptm_delivery_point_id,ptm.ptm_delivery_point AS ptm_delivery_point,ptm.ptm_delivery_time AS ptm_delivery_time,ptm.ptm_delivery_unit AS ptm_delivery_unit,ptm.ptm_buyer AS ptm_buyer,ptm.ptm_buyer_pos_code AS ptm_buyer_pos_code,ptm.ptm_buyer_pos_name AS ptm_buyer_pos_name,ptm.ptm_currency AS ptm_currency,ptm.ptm_contract_type AS ptm_contract_type,ptm.ptm_last_participant AS ptm_last_participant,ptm.ptm_last_participant_code AS ptm_last_participant_code,ptm.ptm_is_contract_created AS ptm_is_contract_created,ptm.ptm_rfq_no AS ptm_rfq_no,ptm.ptm_status AS ptm_status,ptm.ptm_completed_date AS ptm_completed_date,ptm.ptm_tender_id AS ptm_tender_id,ptm.ptm_is_manual AS ptm_is_manual,ptm.ptm_dept_id AS ptm_dept_id,ptm.ptm_dept_name AS ptm_dept_name,ptm.ptm_mata_anggaran AS ptm_mata_anggaran,ptm.ptm_nama_mata_anggaran AS ptm_nama_mata_anggaran,ptm.ptm_sub_mata_anggaran AS ptm_sub_mata_anggaran,ptm.ptm_nama_sub_mata_anggaran AS ptm_nama_sub_mata_anggaran,ptm.ptm_pagu_anggaran AS ptm_pagu_anggaran,ptm.ptm_sisa_anggaran AS ptm_sisa_anggaran,ptm.ptm_requester_id AS ptm_requester_id,ptp.ptp_id AS ptp_id,ptp.ptp_tender_method AS ptp_tender_method,ptp.ptp_submission_method AS ptp_submission_method,ptp.ptp_evaluation_method AS ptp_evaluation_method,ptp.ptp_reg_opening_date AS ptp_reg_opening_date,ptp.ptp_reg_closing_date AS ptp_reg_closing_date,ptp.ptp_prebid_date AS ptp_prebid_date,ptp.ptp_prebid_location AS ptp_prebid_location,ptp.ptp_quot_closing_date AS ptp_quot_closing_date,ptp.ptp_tech_bid_date AS ptp_tech_bid_date,ptp.ptp_quot_opening_date AS ptp_quot_opening_date,ptp.ptp_eauction AS ptp_eauction,ptp.ptp_inquiry_notes AS ptp_inquiry_notes,ptp.ptp_enabled_rank AS ptp_enabled_rank,ptp.ptp_prequalify AS ptp_prequalify,ptp.ptp_doc_open_date AS ptp_doc_open_date,ptp.ptp_preq_info AS ptp_preq_info,ptp.evt_id AS evt_id,ptp.evt_description AS evt_description,ptp.adm_bid_committee AS adm_bid_committee,ptp.adm_bid_committee_name AS adm_bid_committee_name,ptp.ppt_id AS ppt_id,ptp.ppt_name AS ppt_name,ptp.ptp_bid_opening2 AS ptp_bid_opening2,ptp.ptp_tgl_aanwijzing2 AS ptp_tgl_aanwijzing2,ptp.ptp_lokasi_aanwijzing2 AS ptp_lokasi_aanwijzing2,ptp.ptp_klasifikasi_peserta AS ptp_klasifikasi_peserta,ptp.ptp_aanwijzing_online AS ptp_aanwijzing_online,(select scm_dev_db.public.adm_wkf_activity.awa_name from scm_dev_db.public.adm_wkf_activity where (scm_dev_db.public.adm_wkf_activity.awa_id = (select ptc.ptc_activity from scm_dev_db.public.prc_tender_comment ptc where (ptc.ptm_number = ptm.ptm_number) order by ptc.ptc_id desc limit 1))) AS status,pqvs.total AS total_contract,coalesce((select ptc.ptc_activity from scm_dev_db.public.prc_tender_comment ptc where (ptc.ptm_number = ptm.ptm_number) order by ptc.ptc_id desc limit 1),ptm.ptm_status) AS last_status,(select convert_to(ptc.ptc_position, 'UTF8') from scm_dev_db.public.prc_tender_comment ptc where (ptc.ptm_number = ptm.ptm_number) order by ptc.ptc_id desc limit 1) AS last_pos,pqm.pqm_currency AS pqm_currency from (((((scm_dev_db.public.prc_tender_main ptm left join scm_dev_db.public.prc_tender_prep ptp on((ptp.ptm_number = ptm.ptm_number))) left join scm_dev_db.public.prc_tender_vendor_status ptvs on(((ptvs.ptm_number = ptm.ptm_number) and (ptvs.pvs_is_winner = 1)))) left join scm_dev_db.public.vnd_header vnd on((vnd.vendor_id = ptvs.pvs_vendor_code))) left join scm_dev_db.public.prc_tender_quo_main pqm on(((vnd.vendor_id = pqm.ptv_vendor_code) and (ptp.ptm_number = pqm.ptm_number)))) left join scm_dev_db.public.vw_prc_quotation_vendor_sum pqvs on(((vnd.vendor_id = pqvs.ptv_vendor_code) and (pqvs.ptm_number = ptm.ptm_number))));

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

---------------30/05/2018--------------------
ALTER TABLE "public"."prc_plan_main" 
  ADD COLUMN "ppm_type_of_plan" varchar(255),
  ADD COLUMN "ppm_project_name" varchar(255);
----------------------------------------------
-- DROP VIEW "public"."vw_prc_plan_main";

CREATE OR REPLACE VIEW "public"."vw_prc_plan_main" AS SELECT prc_plan_main.ppm_id,
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
            WHEN 3 THEN 'Telah Disetujui Kepala Anggaran'::text
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
    prc_plan_main.ppm_planner_id
   FROM prc_plan_main;

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