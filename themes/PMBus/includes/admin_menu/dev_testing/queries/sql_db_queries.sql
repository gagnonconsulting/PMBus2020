//Finds all distinct product IDs from the company ID 728 (Renesas)
SELECT DISTINCT company.object_id
FROM (SELECT * FROM `wp_term_relationships` WHERE term_taxonomy_id = 728) AS company,
     (SELECT * FROM `wp_term_relationships` WHERE term_taxonomy_id = 728) AS category
WHERE company.object_id = category.object_id

//count the number of entries in an array in php:
count($array_name);

//Find all categories of products by company ID (677 = Intersil)
SELECT * FROM
(
SELECT company.object_id, name, slug, parent FROM
(SELECT * FROM wp_term_relationships r WHERE r.term_taxonomy_id = 677) AS company,
(SELECT * FROM wp_term_relationships r1) AS category,
(SELECT * FROM wp_terms) AS terms,
(SELECT * FROM wp_term_taxonomy) AS taxonomy
WHERE company.object_id = category.object_id AND terms.term_id = category.term_taxonomy_id
AND terms.slug NOT LIKE 'http%' AND terms.name != 'simple'
AND terms.slug NOT LIKE 'Company' AND terms.slug NOT LIKE 'company-%'
AND terms.name != 'featured' AND taxonomy.term_taxonomy_id = terms.term_id
AND taxonomy.taxonomy NOT LIKE 'pa_company'
) as categories

//Finds categories of post based on ID
SELECT * FROM `wp_term_relationships` relation, `wp_terms` terms, `wp_term_taxonomy` parent
WHERE relation.object_id=1725 AND terms.term_id = relation.term_taxonomy_id
AND terms.name != 'simple' AND terms.name != 'featured' AND terms.name != 'Company'
AND terms.name NOT LIKE 'http%' AND terms.slug NOT LIKE 'company-%'
AND parent.term_id = terms.term_id AND parent.taxonomy NOT LIKE 'pa_company%'
"
