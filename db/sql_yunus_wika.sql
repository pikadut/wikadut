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


-------------
---28/06/2018
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
  
  
  -------------
  ---29/06/2018
  DROP VIEW "public"."vw_prc_bidder_list";
CREATE VIEW "public"."vw_prc_bidder_list" AS SELECT prc_tender_vendor_status.ptm_number,
    prc_tender_vendor_status.pvs_vendor_code,
    vnd_header.vendor_name,
        CASE
            WHEN (prc_tender_vendor_status.pvs_technical_status = 0) THEN 'Disqualified'::text
            WHEN (prc_tender_vendor_status.pvs_technical_status = 1) THEN 'Qualified'::text
            WHEN (prc_tender_vendor_status.pvs_technical_status = '-1'::integer) THEN '-'::text
            ELSE 'Belum diverifikasi'::text
        END AS pvs_technical_status,
    prc_tender_vendor_status.pvs_technical_remark,
        CASE
            WHEN (prc_tender_vendor_status.pvs_commercial_status = 0) THEN 'Disqualified'::text
            WHEN (prc_tender_vendor_status.pvs_commercial_status = 1) THEN 'Qualified'::text
            WHEN (prc_tender_vendor_status.pvs_commercial_status = '-1'::integer) THEN '-'::text
            ELSE 'Belum diverifikasi'::text
        END AS pvs_commercial_status,
    prc_tender_vendor_status.pvs_commercial_remark,
    prc_tender_vendor_status.pvs_status AS pvs_status_code,
    z_bidder_status.lkp_description AS pvs_status,
        CASE
            WHEN ((vnd_header.npwp_pkp)::text = 'YA'::text) THEN (tqi.amount * 1.1)
            ELSE tqi.amount
        END AS amount,
    vnd_header.email_address,
        CASE
            WHEN (prc_tender_vendor.ptv_is_attend = 1) THEN 'Yes'::text
            ELSE 'No'::text
        END AS is_attend,
    vnd_header.fin_class,
        CASE
            WHEN (prc_tender_vendor.ptv_is_attend_2 = 1) THEN 'Yes'::text
            ELSE 'No'::text
        END AS is_attend_2
   FROM ((((vnd_header
     JOIN prc_tender_vendor_status ON ((vnd_header.vendor_id = prc_tender_vendor_status.pvs_vendor_code)))
     LEFT JOIN z_bidder_status ON ((COALESCE(prc_tender_vendor_status.pvs_status, 0) = z_bidder_status.lkp_id)))
     LEFT JOIN prc_tender_vendor ON ((((prc_tender_vendor.ptm_number)::text = (prc_tender_vendor_status.ptm_number)::text) AND (prc_tender_vendor.ptv_vendor_code = vnd_header.vendor_id))))
     LEFT JOIN ( SELECT prc_tender_quo_main.ptm_number,
            prc_tender_quo_main.ptv_vendor_code,
            sum(((vw_prc_quotation_item.pqi_quantity)::numeric * vw_prc_quotation_item.pqi_price)) AS amount
           FROM (vw_prc_quotation_item
             JOIN prc_tender_quo_main ON ((vw_prc_quotation_item.pqm_id = prc_tender_quo_main.pqm_id)))
          GROUP BY prc_tender_quo_main.ptm_number, prc_tender_quo_main.ptv_vendor_code) tqi ON (((prc_tender_vendor_status.pvs_vendor_code = tqi.ptv_vendor_code) AND ((prc_tender_vendor_status.ptm_number)::text = (tqi.ptm_number)::text))));

		  
DROP VIEW "public"."vw_quo_main_item";
CREATE VIEW "public"."vw_quo_main_item" AS SELECT prc_tender_quo_main.ptm_number,
    prc_tender_quo_main.ptv_vendor_code,
    sum((vw_prc_quotation_item.pqi_quantity * (vw_prc_quotation_item.pqi_price)::double precision)) AS amount
   FROM (vw_prc_quotation_item
     JOIN prc_tender_quo_main ON ((vw_prc_quotation_item.pqm_id = prc_tender_quo_main.pqm_id)))
  GROUP BY prc_tender_quo_main.ptm_number, prc_tender_quo_main.ptv_vendor_code
  
  
  
 -------------
 ---07/02/2018 
 DROP VIEW "public"."vw_prc_item_sum";

CREATE VIEW "public"."vw_prc_item_sum" AS SELECT SUM
	( prc_tender_item.tit_quantity ) AS total,
	prc_tender_item.tit_code AS code,
	vw_com_catalog.short_description 
FROM
	(
	prc_tender_item
	JOIN vw_com_catalog ON (((
	vw_com_catalog.catalog_code 
	) :: TEXT = ( prc_tender_item.tit_code ) :: TEXT 
	))) 
GROUP BY
	prc_tender_item.tit_code,
	vw_com_catalog.short_description 
ORDER BY
	(
	SUM ( prc_tender_item.tit_quantity )) DESC;

ALTER TABLE "public"."vw_prc_item_sum" OWNER TO "postgres";

COMMENT ON VIEW "public"."vw_prc_item_sum" IS 'Get summary of item';


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
          GROUP BY prc_pr_item.pr_number))::double precision, 0) AS nilai
   FROM prc_pr_main;

ALTER TABLE "public"."vw_daftar_pekerjaan_sppbj" OWNER TO "scm-admin";


-------------
---06/07/2018
INSERT INTO "public"."adm_wkf_activity" VALUES (2021, 'Review Dokumen Kontrak', 'Review Legal', 3, 'CTR', 1, NULL);
INSERT INTO "public"."adm_wkf_activity" VALUES (2022, 'Review Dokumen Kontrak', 'Manager Terkait', 3, 'CTR', 1, NULL);
INSERT INTO "public"."adm_wkf_activity" VALUES (2023, 'Persetujuan Dokumen Kontrak', 'Manager Terkait', 3, 'CTR', 1, NULL);
INSERT INTO "public"."adm_wkf_activity" VALUES (2024, 'Persetujuan Dokumen Kontrak', 'GM Korporasi', 3, 'CTR', 1, NULL);
INSERT INTO "public"."adm_wkf_activity" VALUES (2025, 'Review Dokumen Kontrak', 'GM Korporasi', 3, 'CTR', 1, NULL);
INSERT INTO "public"."adm_wkf_activity" VALUES (2026, 'Persetujuan Dokumen Kontrak', 'Direksi', 3, 'CTR', 1, NULL);

INSERT INTO "public"."adm_wkf_content" VALUES (2010, 'jaminan_v', 4, 'form');

INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2021, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2022, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2023, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2024, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2025, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'milestone_v', 6, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'header_v', 1, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'lampiran_v', 7, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'item_v', 5, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'tunjuk_pelaksana_v', 3, 'view');
INSERT INTO "public"."adm_wkf_content" VALUES (2026, 'jaminan_v', 4, 'view');

INSERT INTO "public"."adm_wkf_response" VALUES (590, 2021, 'Lanjutkan', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (591, 2022, 'Lanjutkan', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (592, 2023, 'Setuju', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (593, 2023, 'Revisi', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (594, 2024, 'Setuju', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (595, 2024, 'Revisi', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (596, 2025, 'Lanjutkan', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (597, 2026, 'Setuju', 1);
INSERT INTO "public"."adm_wkf_response" VALUES (598, 2026, 'Revisi', 1);
