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

