--- 03/06/2018
UPDATE adm_menu SET menu_name = 'PR' WHERE menuid = 163;
UPDATE adm_menu SET menu_name = 'Pembuatan PR' WHERE menuid = 164;
UPDATE adm_menu SET menu_name = 'Daftar PR' WHERE menuid = 180;
UPDATE adm_menu SET menu_name = 'Perencanaan Pengadaan' WHERE menuid = 159;
UPDATE adm_menu SET menu_name = 'Pembuatan Perencanaan Pengadaan' WHERE menuid = 160;
UPDATE adm_menu SET menu_name = 'Data Perencanaan Pengadaan' WHERE menuid = 161;
UPDATE adm_menu SET menu_name = 'Review Perencanaan Pengadaan' WHERE menuid = 162;
UPDATE adm_menu SET menu_name = 'Update Perencanaan Pengadaan' WHERE menuid = 196;
UPDATE adm_menu SET menu_name = 'Rekapitulasi Perencanaan Pengadaan' WHERE menuid = 199;


--------------
--- 21/06/2018
ALTER TABLE "public"."prc_pr_main" 
  ADD COLUMN "pr_type_of_plan" varchar(255),
  ADD COLUMN "pr_project_name" varchar(255),
  ADD COLUMN "pr_type" varchar(255);

  
--------------
--- 25/06/2018
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
         LIMIT 1) AS last_pos
   FROM prc_pr_main pr;
ALTER TABLE "public"."vw_prc_pr_monitor" OWNER TO "postgres";
COMMENT ON VIEW "public"."vw_prc_pr_monitor" IS 'Monitor PR';


-----------
---26062018
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
          GROUP BY prc_pr_item.pr_number))::integer, 0) AS nilai
   FROM prc_pr_main;

ALTER TABLE "public"."vw_daftar_pekerjaan_sppbj" OWNER TO "postgres";