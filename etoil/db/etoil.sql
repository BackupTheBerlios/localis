--
-- PostgreSQL database dump
--

SET client_encoding = 'SQL_ASCII';
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

DROP INDEX public.login;
ALTER TABLE ONLY public.spatial_ref_sys DROP CONSTRAINT spatial_ref_sys_pkey;
ALTER TABLE ONLY public.geometry_columns DROP CONSTRAINT geometry_columns_pk;
DROP TABLE public.users;
DROP TABLE public.spatial_ref_sys;
DROP TABLE public.geometry_columns;
DROP TABLE public.conf;
SET search_path = pg_catalog;

DROP CAST (text AS public.geometry);
DROP CAST (public.geometry AS text);
DROP CAST (public.geometry AS bytea);
DROP CAST (public.geometry AS public.box3d);
DROP CAST (public.geometry AS public.box2d);
DROP CAST (public.geometry AS box);
DROP CAST (public.chip AS public.geometry);
DROP CAST (bytea AS public.geometry);
DROP CAST (public.box3d AS public.geometry);
DROP CAST (public.box3d AS public.box2d);
DROP CAST (public.box3d AS box);
DROP CAST (public.box2d AS public.geometry);
DROP CAST (public.box2d AS public.box3d);
SET search_path = public, pg_catalog;

DROP OPERATOR CLASS public.gist_geometry_ops USING gist;
DROP OPERATOR CLASS public.btree_geometry_ops USING btree;
DROP OPERATOR public.~= (geometry, geometry);
DROP OPERATOR public.~ (geometry, geometry);
DROP OPERATOR public.|>> (geometry, geometry);
DROP OPERATOR public.|&> (geometry, geometry);
DROP OPERATOR public.@ (geometry, geometry);
DROP OPERATOR public.>> (geometry, geometry);
DROP OPERATOR public.>= (geometry, geometry);
DROP OPERATOR public.> (geometry, geometry);
DROP OPERATOR public.= (geometry, geometry);
DROP OPERATOR public.<= (geometry, geometry);
DROP OPERATOR public.<<| (geometry, geometry);
DROP OPERATOR public.<< (geometry, geometry);
DROP OPERATOR public.< (geometry, geometry);
DROP OPERATOR public.&> (geometry, geometry);
DROP OPERATOR public.&<| (geometry, geometry);
DROP OPERATOR public.&< (geometry, geometry);
DROP OPERATOR public.&& (geometry, geometry);
DROP AGGREGATE public.polygonize(geometry);
DROP AGGREGATE public.memgeomunion(geometry);
DROP AGGREGATE public.memcollect(geometry);
DROP AGGREGATE public.makeline(geometry);
DROP AGGREGATE public.geomunion(geometry);
DROP AGGREGATE public.extent3d(geometry);
DROP AGGREGATE public.extent(geometry);
DROP AGGREGATE public.collect(geometry);
DROP AGGREGATE public.accum(geometry);
DROP FUNCTION public.zmin(box3d);
DROP FUNCTION public.zmflag(geometry);
DROP FUNCTION public.zmax(box3d);
DROP FUNCTION public.z(geometry);
DROP FUNCTION public.ymin(box2d);
DROP FUNCTION public.ymin(box3d);
DROP FUNCTION public.ymax(box2d);
DROP FUNCTION public.ymax(box3d);
DROP FUNCTION public.y(geometry);
DROP FUNCTION public.xmin(box2d);
DROP FUNCTION public.xmin(box3d);
DROP FUNCTION public.xmax(box2d);
DROP FUNCTION public.xmax(box3d);
DROP FUNCTION public.x(geometry);
DROP FUNCTION public.within(geometry, geometry);
DROP FUNCTION public.width(chip);
DROP FUNCTION public.updategeometrysrid(character varying, character varying, integer);
DROP FUNCTION public.updategeometrysrid(character varying, character varying, character varying, integer);
DROP FUNCTION public.updategeometrysrid(character varying, character varying, character varying, character varying, integer);
DROP FUNCTION public.update_geometry_stats(character varying, character varying);
DROP FUNCTION public.update_geometry_stats();
DROP FUNCTION public.unite_garray(geometry[]);
DROP FUNCTION public.translate(geometry, double precision, double precision);
DROP FUNCTION public.translate(geometry, double precision, double precision, double precision);
DROP FUNCTION public.transform_geometry(geometry, text, text, integer);
DROP FUNCTION public.transform(geometry, integer);
DROP FUNCTION public.touches(geometry, geometry);
DROP FUNCTION public.text(geometry);
DROP FUNCTION public.symmetricdifference(geometry, geometry);
DROP FUNCTION public.symdifference(geometry, geometry);
DROP FUNCTION public.summary(geometry);
DROP FUNCTION public.startpoint(geometry);
DROP FUNCTION public.srid(geometry);
DROP FUNCTION public.srid(chip);
DROP FUNCTION public.snaptogrid(geometry, double precision);
DROP FUNCTION public.snaptogrid(geometry, double precision, double precision);
DROP FUNCTION public.snaptogrid(geometry, double precision, double precision, double precision, double precision);
DROP FUNCTION public.simplify(geometry, double precision);
DROP FUNCTION public.setsrid(geometry, integer);
DROP FUNCTION public.setsrid(chip, integer);
DROP FUNCTION public.setfactor(chip, real);
DROP FUNCTION public.segmentize(geometry, double precision);
DROP FUNCTION public.reverse(geometry);
DROP FUNCTION public.rename_geometry_table_constraints();
DROP FUNCTION public.relate(geometry, geometry, text);
DROP FUNCTION public.relate(geometry, geometry);
DROP FUNCTION public.probe_geometry_columns();
DROP FUNCTION public.postgis_version();
DROP FUNCTION public.postgis_uses_stats();
DROP FUNCTION public.postgis_scripts_released();
DROP FUNCTION public.postgis_scripts_installed();
DROP FUNCTION public.postgis_scripts_build_date();
DROP FUNCTION public.postgis_proj_version();
DROP FUNCTION public.postgis_lib_version();
DROP FUNCTION public.postgis_lib_build_date();
DROP FUNCTION public.postgis_gist_sel(internal, oid, internal, integer);
DROP FUNCTION public.postgis_gist_joinsel(internal, oid, internal, smallint);
DROP FUNCTION public.postgis_geos_version();
DROP FUNCTION public.postgis_full_version();
DROP FUNCTION public.polygonize_garray(geometry[]);
DROP FUNCTION public.polygonfromwkb(bytea);
DROP FUNCTION public.polygonfromwkb(bytea, integer);
DROP FUNCTION public.polygonfromtext(text);
DROP FUNCTION public.polygonfromtext(text, integer);
DROP FUNCTION public.polyfromwkb(bytea);
DROP FUNCTION public.polyfromwkb(bytea, integer);
DROP FUNCTION public.polyfromtext(text, integer);
DROP FUNCTION public.polyfromtext(text);
DROP FUNCTION public.pointonsurface(geometry);
DROP FUNCTION public.pointn(geometry, integer);
DROP FUNCTION public.pointfromwkb(bytea);
DROP FUNCTION public.pointfromwkb(bytea, integer);
DROP FUNCTION public.pointfromtext(text, integer);
DROP FUNCTION public.pointfromtext(text);
DROP FUNCTION public.point_inside_circle(geometry, double precision, double precision, double precision);
DROP FUNCTION public.perimeter3d(geometry);
DROP FUNCTION public.perimeter2d(geometry);
DROP FUNCTION public.perimeter(geometry);
DROP FUNCTION public."overlaps"(geometry, geometry);
DROP FUNCTION public.numpoints(geometry);
DROP FUNCTION public.numinteriorrings(geometry);
DROP FUNCTION public.numgeometries(geometry);
DROP FUNCTION public.nrings(geometry);
DROP FUNCTION public.npoints(geometry);
DROP FUNCTION public.noop(geometry);
DROP FUNCTION public.ndims(geometry);
DROP FUNCTION public.multipolygonfromtext(text);
DROP FUNCTION public.multipolygonfromtext(text, integer);
DROP FUNCTION public.multipolyfromwkb(bytea);
DROP FUNCTION public.multipolyfromwkb(bytea, integer);
DROP FUNCTION public.multipointfromwkb(bytea);
DROP FUNCTION public.multipointfromwkb(bytea, integer);
DROP FUNCTION public.multipointfromtext(text);
DROP FUNCTION public.multipointfromtext(text, integer);
DROP FUNCTION public.multilinestringfromtext(text, integer);
DROP FUNCTION public.multilinestringfromtext(text);
DROP FUNCTION public.multilinefromwkb(bytea);
DROP FUNCTION public.multilinefromwkb(bytea, integer);
DROP FUNCTION public.multi(geometry);
DROP FUNCTION public.mpolyfromwkb(bytea);
DROP FUNCTION public.mpolyfromwkb(bytea, integer);
DROP FUNCTION public.mpolyfromtext(text);
DROP FUNCTION public.mpolyfromtext(text, integer);
DROP FUNCTION public.mpointfromwkb(bytea);
DROP FUNCTION public.mpointfromwkb(bytea, integer);
DROP FUNCTION public.mpointfromtext(text);
DROP FUNCTION public.mpointfromtext(text, integer);
DROP FUNCTION public.mlinefromwkb(bytea);
DROP FUNCTION public.mlinefromwkb(bytea, integer);
DROP FUNCTION public.mlinefromtext(text);
DROP FUNCTION public.mlinefromtext(text, integer);
DROP FUNCTION public.mem_size(geometry);
DROP FUNCTION public.max_distance(geometry, geometry);
DROP FUNCTION public.makepolygon(geometry);
DROP FUNCTION public.makepolygon(geometry, geometry[]);
DROP FUNCTION public.makepointm(double precision, double precision, double precision);
DROP FUNCTION public.makepoint(double precision, double precision, double precision, double precision);
DROP FUNCTION public.makepoint(double precision, double precision, double precision);
DROP FUNCTION public.makepoint(double precision, double precision);
DROP FUNCTION public.makeline_garray(geometry[]);
DROP FUNCTION public.makeline(geometry, geometry);
DROP FUNCTION public.makebox3d(geometry, geometry);
DROP FUNCTION public.makebox2d(geometry, geometry);
DROP FUNCTION public.lwgeom_gist_union(bytea, internal);
DROP FUNCTION public.lwgeom_gist_same(box2d, box2d, internal);
DROP FUNCTION public.lwgeom_gist_picksplit(internal, internal);
DROP FUNCTION public.lwgeom_gist_penalty(internal, internal, internal);
DROP FUNCTION public.lwgeom_gist_decompress(internal);
DROP FUNCTION public.lwgeom_gist_consistent(internal, geometry, integer);
DROP FUNCTION public.lwgeom_gist_compress(internal);
DROP FUNCTION public.linestringfromwkb(bytea);
DROP FUNCTION public.linestringfromwkb(bytea, integer);
DROP FUNCTION public.linestringfromtext(text, integer);
DROP FUNCTION public.linestringfromtext(text);
DROP FUNCTION public.linefromwkb(bytea);
DROP FUNCTION public.linefromwkb(bytea, integer);
DROP FUNCTION public.linefromtext(text, integer);
DROP FUNCTION public.linefromtext(text);
DROP FUNCTION public.linefrommultipoint(geometry);
DROP FUNCTION public.line_interpolate_point(geometry, double precision);
DROP FUNCTION public.length_spheroid(geometry, spheroid);
DROP FUNCTION public.length3d_spheroid(geometry, spheroid);
DROP FUNCTION public.length3d(geometry);
DROP FUNCTION public.length2d_spheroid(geometry, spheroid);
DROP FUNCTION public.length2d(geometry);
DROP FUNCTION public.length(geometry);
DROP FUNCTION public.isvalid(geometry);
DROP FUNCTION public.issimple(geometry);
DROP FUNCTION public.isring(geometry);
DROP FUNCTION public.isempty(geometry);
DROP FUNCTION public.isclosed(geometry);
DROP FUNCTION public.intersects(geometry, geometry);
DROP FUNCTION public.intersection(geometry, geometry);
DROP FUNCTION public.interiorringn(geometry, integer);
DROP FUNCTION public.height(chip);
DROP FUNCTION public.hasbbox(geometry);
DROP FUNCTION public.getsrid(geometry);
DROP FUNCTION public.getbbox(geometry);
DROP FUNCTION public.get_proj4_from_srid(integer);
DROP FUNCTION public.geosnoop(geometry);
DROP FUNCTION public.geomunion(geometry, geometry);
DROP FUNCTION public.geomfromwkb(bytea, integer);
DROP FUNCTION public.geomfromwkb(bytea);
DROP FUNCTION public.geomfromtext(text, integer);
DROP FUNCTION public.geomfromtext(text);
DROP FUNCTION public.geomfromewkt(text);
DROP FUNCTION public.geomfromewkb(bytea);
DROP FUNCTION public.geometrytype(geometry);
DROP FUNCTION public.geometryn(geometry, integer);
DROP FUNCTION public.geometryfromtext(text, integer);
DROP FUNCTION public.geometryfromtext(text);
DROP FUNCTION public.geometry_same(geometry, geometry);
DROP FUNCTION public.geometry_right(geometry, geometry);
DROP FUNCTION public.geometry_overright(geometry, geometry);
DROP FUNCTION public.geometry_overleft(geometry, geometry);
DROP FUNCTION public.geometry_overlap(geometry, geometry);
DROP FUNCTION public.geometry_overbelow(geometry, geometry);
DROP FUNCTION public.geometry_overabove(geometry, geometry);
DROP FUNCTION public.geometry_lt(geometry, geometry);
DROP FUNCTION public.geometry_left(geometry, geometry);
DROP FUNCTION public.geometry_le(geometry, geometry);
DROP FUNCTION public.geometry_gt(geometry, geometry);
DROP FUNCTION public.geometry_ge(geometry, geometry);
DROP FUNCTION public.geometry_eq(geometry, geometry);
DROP FUNCTION public.geometry_contained(geometry, geometry);
DROP FUNCTION public.geometry_contain(geometry, geometry);
DROP FUNCTION public.geometry_cmp(geometry, geometry);
DROP FUNCTION public.geometry_below(geometry, geometry);
DROP FUNCTION public.geometry_above(geometry, geometry);
DROP FUNCTION public.geometry(bytea);
DROP FUNCTION public.geometry(chip);
DROP FUNCTION public.geometry(text);
DROP FUNCTION public.geometry(box3d);
DROP FUNCTION public.geometry(box2d);
DROP FUNCTION public.geomcollfromwkb(bytea);
DROP FUNCTION public.geomcollfromwkb(bytea, integer);
DROP FUNCTION public.geomcollfromtext(text);
DROP FUNCTION public.geomcollfromtext(text, integer);
DROP FUNCTION public.geom_accum(geometry[], geometry);
DROP FUNCTION public.forcerhr(geometry);
DROP FUNCTION public.force_collection(geometry);
DROP FUNCTION public.force_4d(geometry);
DROP FUNCTION public.force_3dz(geometry);
DROP FUNCTION public.force_3dm(geometry);
DROP FUNCTION public.force_3d(geometry);
DROP FUNCTION public.force_2d(geometry);
DROP FUNCTION public.fix_geometry_columns();
DROP FUNCTION public.find_srid(character varying, character varying, character varying);
DROP FUNCTION public.find_extent(text, text);
DROP FUNCTION public.find_extent(text, text, text);
DROP FUNCTION public.factor(chip);
DROP FUNCTION public.exteriorring(geometry);
DROP FUNCTION public.explode_histogram2d(histogram2d, text);
DROP FUNCTION public.expand(geometry, double precision);
DROP FUNCTION public.expand(box2d, double precision);
DROP FUNCTION public.expand(box3d, double precision);
DROP FUNCTION public.estimated_extent(text, text);
DROP FUNCTION public.estimated_extent(text, text, text);
DROP FUNCTION public.estimate_histogram2d(histogram2d, box2d);
DROP FUNCTION public.equals(geometry, geometry);
DROP FUNCTION public.envelope(geometry);
DROP FUNCTION public.endpoint(geometry);
DROP FUNCTION public.dump(geometry);
DROP FUNCTION public.dropgeometrytable(character varying);
DROP FUNCTION public.dropgeometrytable(character varying, character varying);
DROP FUNCTION public.dropgeometrytable(character varying, character varying, character varying);
DROP FUNCTION public.dropgeometrycolumn(character varying, character varying);
DROP FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying);
DROP FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying, character varying);
DROP FUNCTION public.dropbbox(geometry);
DROP FUNCTION public.distance_spheroid(geometry, geometry, spheroid);
DROP FUNCTION public.distance(geometry, geometry);
DROP FUNCTION public.disjoint(geometry, geometry);
DROP FUNCTION public.dimension(geometry);
DROP FUNCTION public.difference(geometry, geometry);
DROP FUNCTION public.datatype(chip);
DROP FUNCTION public.crosses(geometry, geometry);
DROP FUNCTION public.create_histogram2d(box2d, integer);
DROP FUNCTION public.convexhull(geometry);
DROP FUNCTION public.contains(geometry, geometry);
DROP FUNCTION public.compression(chip);
DROP FUNCTION public.combine_bbox(box3d, geometry);
DROP FUNCTION public.combine_bbox(box2d, geometry);
DROP FUNCTION public.collector(geometry, geometry);
DROP FUNCTION public.collect_garray(geometry[]);
DROP FUNCTION public.collect(geometry, geometry);
DROP FUNCTION public.centroid(geometry);
DROP FUNCTION public.cache_bbox();
DROP FUNCTION public.bytea(geometry);
DROP FUNCTION public.build_histogram2d(histogram2d, text, text, text);
DROP FUNCTION public.build_histogram2d(histogram2d, text, text);
DROP FUNCTION public.buffer(geometry, double precision, integer);
DROP FUNCTION public.buffer(geometry, double precision);
DROP FUNCTION public.box3dtobox(box3d);
DROP FUNCTION public.box3d(box2d);
DROP FUNCTION public.box3d(geometry);
DROP FUNCTION public.box2d_same(box2d, box2d);
DROP FUNCTION public.box2d_right(box2d, box2d);
DROP FUNCTION public.box2d_overright(box2d, box2d);
DROP FUNCTION public.box2d_overleft(box2d, box2d);
DROP FUNCTION public.box2d_overlap(box2d, box2d);
DROP FUNCTION public.box2d_left(box2d, box2d);
DROP FUNCTION public.box2d_intersects(box2d, box2d);
DROP FUNCTION public.box2d_contained(box2d, box2d);
DROP FUNCTION public.box2d_contain(box2d, box2d);
DROP FUNCTION public.box2d(box3d);
DROP FUNCTION public.box2d(geometry);
DROP FUNCTION public.box(box3d);
DROP FUNCTION public.box(geometry);
DROP FUNCTION public.boundary(geometry);
DROP FUNCTION public.astext(geometry);
DROP FUNCTION public.assvg(geometry);
DROP FUNCTION public.assvg(geometry, integer);
DROP FUNCTION public.assvg(geometry, integer, integer);
DROP FUNCTION public.asgml(geometry);
DROP FUNCTION public.asgml(geometry, integer);
DROP FUNCTION public.asgml(geometry, integer, integer);
DROP FUNCTION public.asewkt(geometry);
DROP FUNCTION public.asewkb(geometry, text);
DROP FUNCTION public.asewkb(geometry);
DROP FUNCTION public.asbinary(geometry, text);
DROP FUNCTION public.asbinary(geometry);
DROP FUNCTION public.area2d(geometry);
DROP FUNCTION public.area(geometry);
DROP FUNCTION public.addpoint(geometry, geometry, integer);
DROP FUNCTION public.addpoint(geometry, geometry);
DROP FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer);
DROP FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer);
DROP FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer);
DROP FUNCTION public.addbbox(geometry);
DROP TYPE public.geometry_dump;
DROP TYPE public.spheroid CASCADE;
DROP FUNCTION public.spheroid_out(spheroid);
DROP FUNCTION public.spheroid_in(cstring);
DROP TYPE public.histogram2d CASCADE;
DROP FUNCTION public.histogram2d_out(histogram2d);
DROP FUNCTION public.histogram2d_in(cstring);
DROP TYPE public.geometry CASCADE;
DROP FUNCTION public.geometry_send(geometry);
DROP FUNCTION public.geometry_recv(internal);
DROP FUNCTION public.geometry_out(geometry);
DROP FUNCTION public.geometry_in(cstring);
DROP FUNCTION public.geometry_analyze(internal);
DROP TYPE public.chip CASCADE;
DROP FUNCTION public.chip_out(chip);
DROP FUNCTION public.chip_in(cstring);
DROP TYPE public.box3d CASCADE;
DROP FUNCTION public.box3d_out(box3d);
DROP FUNCTION public.box3d_in(cstring);
DROP TYPE public.box2d CASCADE;
DROP FUNCTION public.box2d_out(box2d);
DROP FUNCTION public.box2d_in(cstring);
DROP PROCEDURAL LANGUAGE plpgsql;
DROP FUNCTION public.plpgsql_call_handler();
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


--
-- Name: plpgsql_call_handler(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION plpgsql_call_handler() RETURNS language_handler
    AS '$libdir/plpgsql', 'plpgsql_call_handler'
    LANGUAGE c;


ALTER FUNCTION public.plpgsql_call_handler() OWNER TO mose;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: public; Owner: 
--

CREATE TRUSTED PROCEDURAL LANGUAGE plpgsql HANDLER plpgsql_call_handler;


--
-- Name: box2d_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_in(cstring) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_in(cstring) OWNER TO mose;

--
-- Name: box2d_out(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_out(box2d) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_out(box2d) OWNER TO mose;

--
-- Name: box2d; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE box2d (
    INTERNALLENGTH = 16,
    INPUT = box2d_in,
    OUTPUT = box2d_out,
    ALIGNMENT = int4,
    STORAGE = plain
);


ALTER TYPE public.box2d OWNER TO mose;

--
-- Name: box3d_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box3d_in(cstring) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box3d_in(cstring) OWNER TO mose;

--
-- Name: box3d_out(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box3d_out(box3d) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box3d_out(box3d) OWNER TO mose;

--
-- Name: box3d; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE box3d (
    INTERNALLENGTH = 48,
    INPUT = box3d_in,
    OUTPUT = box3d_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.box3d OWNER TO mose;

--
-- Name: chip_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION chip_in(cstring) RETURNS chip
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.chip_in(cstring) OWNER TO mose;

--
-- Name: chip_out(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION chip_out(chip) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.chip_out(chip) OWNER TO mose;

--
-- Name: chip; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE chip (
    INTERNALLENGTH = variable,
    INPUT = chip_in,
    OUTPUT = chip_out,
    ALIGNMENT = double,
    STORAGE = extended
);


ALTER TYPE public.chip OWNER TO mose;

--
-- Name: geometry_analyze(internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_analyze(internal) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_analyze'
    LANGUAGE c STRICT;


ALTER FUNCTION public.geometry_analyze(internal) OWNER TO mose;

--
-- Name: geometry_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_in(cstring) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_in(cstring) OWNER TO mose;

--
-- Name: geometry_out(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_out(geometry) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_out(geometry) OWNER TO mose;

--
-- Name: geometry_recv(internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_recv(internal) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_recv'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_recv(internal) OWNER TO mose;

--
-- Name: geometry_send(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_send(geometry) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_send'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_send(geometry) OWNER TO mose;

--
-- Name: geometry; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE geometry (
    INTERNALLENGTH = variable,
    INPUT = geometry_in,
    OUTPUT = geometry_out,
    RECEIVE = geometry_recv,
    SEND = geometry_send,
    ANALYZE = geometry_analyze,
    DELIMITER = ':',
    ALIGNMENT = int4,
    STORAGE = main
);


ALTER TYPE public.geometry OWNER TO mose;

--
-- Name: histogram2d_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION histogram2d_in(cstring) RETURNS histogram2d
    AS '$libdir/liblwgeom.so.1.0', 'lwhistogram2d_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.histogram2d_in(cstring) OWNER TO mose;

--
-- Name: histogram2d_out(histogram2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION histogram2d_out(histogram2d) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'lwhistogram2d_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.histogram2d_out(histogram2d) OWNER TO mose;

--
-- Name: histogram2d; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE histogram2d (
    INTERNALLENGTH = variable,
    INPUT = histogram2d_in,
    OUTPUT = histogram2d_out,
    ALIGNMENT = double,
    STORAGE = main
);


ALTER TYPE public.histogram2d OWNER TO mose;

--
-- Name: spheroid_in(cstring); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION spheroid_in(cstring) RETURNS spheroid
    AS '$libdir/liblwgeom.so.1.0', 'ellipsoid_in'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.spheroid_in(cstring) OWNER TO mose;

--
-- Name: spheroid_out(spheroid); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION spheroid_out(spheroid) RETURNS cstring
    AS '$libdir/liblwgeom.so.1.0', 'ellipsoid_out'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.spheroid_out(spheroid) OWNER TO mose;

--
-- Name: spheroid; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE spheroid (
    INTERNALLENGTH = 65,
    INPUT = spheroid_in,
    OUTPUT = spheroid_out,
    ALIGNMENT = double,
    STORAGE = plain
);


ALTER TYPE public.spheroid OWNER TO mose;

--
-- Name: geometry_dump; Type: TYPE; Schema: public; Owner: mose
--

CREATE TYPE geometry_dump AS (
	path integer[],
	geom geometry
);


ALTER TYPE public.geometry_dump OWNER TO mose;

--
-- Name: addbbox(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addbbox(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_addBBOX'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.addbbox(geometry) OWNER TO mose;

--
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	new_type alias for $6;
	new_dim alias for $7;

	rec RECORD;
	schema_ok bool;
	real_schema name;

	fixgeomres text;

BEGIN

	IF ( not ( (new_type ='GEOMETRY') or
		   (new_type ='GEOMETRYCOLLECTION') or
		   (new_type ='POINT') or 
		   (new_type ='MULTIPOINT') or
		   (new_type ='POLYGON') or
		   (new_type ='MULTIPOLYGON') or
		   (new_type ='LINESTRING') or
		   (new_type ='MULTILINESTRING') or
		   (new_type ='GEOMETRYCOLLECTIONM') or
		   (new_type ='POINTM') or 
		   (new_type ='MULTIPOINTM') or
		   (new_type ='POLYGONM') or
		   (new_type ='MULTIPOLYGONM') or
		   (new_type ='LINESTRINGM') or
		   (new_type ='MULTILINESTRINGM')) )
	THEN
		RAISE EXCEPTION 'Invalid type name - valid ones are: 
			GEOMETRY, GEOMETRYCOLLECTION, POINT, 
			MULTIPOINT, POLYGON, MULTIPOLYGON, 
			LINESTRING, MULTILINESTRING,
			GEOMETRYCOLLECTIONM, POINTM, 
			MULTIPOINTM, POLYGONM, MULTIPOLYGONM, 
			LINESTRINGM, or MULTILINESTRINGM ';
		return 'fail';
	END IF;

	IF ( (new_dim >4) or (new_dim <0) ) THEN
		RAISE EXCEPTION 'invalid dimension';
		return 'fail';
	END IF;

	IF ( (new_type LIKE '%M') and (new_dim!=3) ) THEN

		RAISE EXCEPTION 'TypeM needs 3 dimensions';
		return 'fail';
	END IF;


	IF ( schema_name != '' ) THEN
		schema_ok = 'f';
		FOR rec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			schema_ok := 't';
		END LOOP;

		if ( schema_ok <> 't' ) THEN
			RAISE NOTICE 'Invalid schema name - using current_schema()';
			SELECT current_schema() into real_schema;
		ELSE
			real_schema = schema_name;
		END IF;

	ELSE
		SELECT current_schema() into real_schema;
	END IF;



	-- Add geometry column

	EXECUTE 'ALTER TABLE ' ||

		quote_ident(real_schema) || '.' || quote_ident(table_name)



		|| ' ADD COLUMN ' || quote_ident(column_name) || 
		' geometry ';


	-- Delete stale record in geometry_column (if any)

	EXECUTE 'DELETE FROM geometry_columns WHERE
		f_table_catalog = ' || quote_literal('') || 
		' AND f_table_schema = ' ||

		quote_literal(real_schema) || 



		' AND f_table_name = ' || quote_literal(table_name) ||
		' AND f_geometry_column = ' || quote_literal(column_name);


	-- Add record in geometry_column 

	EXECUTE 'INSERT INTO geometry_columns VALUES (' ||
		quote_literal('') || ',' ||

		quote_literal(real_schema) || ',' ||



		quote_literal(table_name) || ',' ||
		quote_literal(column_name) || ',' ||
		new_dim || ',' || new_srid || ',' ||
		quote_literal(new_type) || ')';

	-- Add table checks

	EXECUTE 'ALTER TABLE ' || 

		quote_ident(real_schema) || '.' || quote_ident(table_name)



		|| ' ADD CONSTRAINT ' 
		|| quote_ident('enforce_srid_' || column_name)
		|| ' CHECK (SRID(' || quote_ident(column_name) ||
		') = ' || new_srid || ')' ;

	EXECUTE 'ALTER TABLE ' || 

		quote_ident(real_schema) || '.' || quote_ident(table_name)



		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_dims_' || column_name)
		|| ' CHECK (ndims(' || quote_ident(column_name) ||
		') = ' || new_dim || ')' ;

	IF (not(new_type = 'GEOMETRY')) THEN
		EXECUTE 'ALTER TABLE ' || 

		quote_ident(real_schema) || '.' || quote_ident(table_name)



		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_geotype_' || column_name)
		|| ' CHECK (geometrytype(' ||
		quote_ident(column_name) || ')=' ||
		quote_literal(new_type) || ' OR (' ||
		quote_ident(column_name) || ') is null)';
	END IF;

	SELECT fix_geometry_columns() INTO fixgeomres;

	return 

		real_schema || '.' || 

		table_name || '.' || column_name ||
		' SRID:' || new_srid ||
		' TYPE:' || new_type || 
		' DIMS:' || new_dim || '
 ' ||
		'geometry_column ' || fixgeomres;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) OWNER TO mose;

--
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('',$1,$2,$3,$4,$5,$6) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) OWNER TO mose;

--
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) RETURNS text
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('','',$1,$2,$3,$4,$5) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer) OWNER TO mose;

--
-- Name: addpoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addpoint(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_addpoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.addpoint(geometry, geometry) OWNER TO mose;

--
-- Name: addpoint(geometry, geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION addpoint(geometry, geometry, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_addpoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.addpoint(geometry, geometry, integer) OWNER TO mose;

--
-- Name: area(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION area(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_area_polygon'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.area(geometry) OWNER TO mose;

--
-- Name: area2d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION area2d(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_area_polygon'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.area2d(geometry) OWNER TO mose;

--
-- Name: asbinary(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asbinary(geometry) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asBinary'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asbinary(geometry) OWNER TO mose;

--
-- Name: asbinary(geometry, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asbinary(geometry, text) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asBinary'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asbinary(geometry, text) OWNER TO mose;

--
-- Name: asewkb(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asewkb(geometry) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'WKBFromLWGEOM'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asewkb(geometry) OWNER TO mose;

--
-- Name: asewkb(geometry, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asewkb(geometry, text) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'WKBFromLWGEOM'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asewkb(geometry, text) OWNER TO mose;

--
-- Name: asewkt(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asewkt(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asEWKT'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asewkt(geometry) OWNER TO mose;

--
-- Name: asgml(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asgml(geometry, integer, integer) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asGML'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asgml(geometry, integer, integer) OWNER TO mose;

--
-- Name: asgml(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asgml(geometry, integer) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asGML'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asgml(geometry, integer) OWNER TO mose;

--
-- Name: asgml(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION asgml(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asGML'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.asgml(geometry) OWNER TO mose;

--
-- Name: assvg(geometry, integer, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION assvg(geometry, integer, integer) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'assvg_geometry'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.assvg(geometry, integer, integer) OWNER TO mose;

--
-- Name: assvg(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION assvg(geometry, integer) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'assvg_geometry'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.assvg(geometry, integer) OWNER TO mose;

--
-- Name: assvg(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION assvg(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'assvg_geometry'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.assvg(geometry) OWNER TO mose;

--
-- Name: astext(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION astext(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_asText'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.astext(geometry) OWNER TO mose;

--
-- Name: boundary(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION boundary(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'boundary'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.boundary(geometry) OWNER TO mose;

--
-- Name: box(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box(geometry) RETURNS box
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_BOX'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box(geometry) OWNER TO mose;

--
-- Name: box(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box(box3d) RETURNS box
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_to_BOX'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box(box3d) OWNER TO mose;

--
-- Name: box2d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d(geometry) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_BOX2DFLOAT4'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d(geometry) OWNER TO mose;

--
-- Name: box2d(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d(box3d) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_to_BOX2DFLOAT4'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d(box3d) OWNER TO mose;

--
-- Name: box2d_contain(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_contain(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_contain'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_contain(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_contained(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_contained(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_contained'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_contained(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_intersects(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_intersects(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_intersects'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_intersects(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_left(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_left(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_left'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_left(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_overlap(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_overlap(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_overlap'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_overlap(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_overleft(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_overleft(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_overleft'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_overleft(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_overright(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_overright(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_overright'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_overright(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_right(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_right(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_right'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_right(box2d, box2d) OWNER TO mose;

--
-- Name: box2d_same(box2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box2d_same(box2d, box2d) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'BOX2D_same'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box2d_same(box2d, box2d) OWNER TO mose;

--
-- Name: box3d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box3d(geometry) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_BOX3D'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box3d(geometry) OWNER TO mose;

--
-- Name: box3d(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box3d(box2d) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_to_BOX3D'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.box3d(box2d) OWNER TO mose;

--
-- Name: box3dtobox(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION box3dtobox(box3d) RETURNS box
    AS $_$SELECT box($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.box3dtobox(box3d) OWNER TO mose;

--
-- Name: buffer(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION buffer(geometry, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'buffer'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.buffer(geometry, double precision) OWNER TO mose;

--
-- Name: buffer(geometry, double precision, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION buffer(geometry, double precision, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'buffer'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.buffer(geometry, double precision, integer) OWNER TO mose;

--
-- Name: build_histogram2d(histogram2d, text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION build_histogram2d(histogram2d, text, text) RETURNS histogram2d
    AS '$libdir/liblwgeom.so.1.0', 'build_lwhistogram2d'
    LANGUAGE c STABLE STRICT;


ALTER FUNCTION public.build_histogram2d(histogram2d, text, text) OWNER TO mose;

--
-- Name: build_histogram2d(histogram2d, text, text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION build_histogram2d(histogram2d, text, text, text) RETURNS histogram2d
    AS $_$
BEGIN
	EXECUTE 'SET local search_path = '||$2||',public';
	RETURN public.build_histogram2d($1,$3,$4);
END
$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.build_histogram2d(histogram2d, text, text, text) OWNER TO mose;

--
-- Name: bytea(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION bytea(geometry) RETURNS bytea
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_bytea'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.bytea(geometry) OWNER TO mose;

--
-- Name: cache_bbox(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION cache_bbox() RETURNS "trigger"
    AS '$libdir/liblwgeom.so.1.0', 'cache_bbox'
    LANGUAGE c;


ALTER FUNCTION public.cache_bbox() OWNER TO mose;

--
-- Name: centroid(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION centroid(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'centroid'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.centroid(geometry) OWNER TO mose;

--
-- Name: collect(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION collect(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_collect'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.collect(geometry, geometry) OWNER TO mose;

--
-- Name: collect_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION collect_garray(geometry[]) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_collect_garray'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.collect_garray(geometry[]) OWNER TO mose;

--
-- Name: collector(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION collector(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_collect'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.collector(geometry, geometry) OWNER TO mose;

--
-- Name: combine_bbox(box2d, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION combine_bbox(box2d, geometry) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_combine'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.combine_bbox(box2d, geometry) OWNER TO mose;

--
-- Name: combine_bbox(box3d, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION combine_bbox(box3d, geometry) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_combine'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.combine_bbox(box3d, geometry) OWNER TO mose;

--
-- Name: compression(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION compression(chip) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getCompression'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.compression(chip) OWNER TO mose;

--
-- Name: contains(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION contains(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'contains'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.contains(geometry, geometry) OWNER TO mose;

--
-- Name: convexhull(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION convexhull(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'convexhull'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.convexhull(geometry) OWNER TO mose;

--
-- Name: create_histogram2d(box2d, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION create_histogram2d(box2d, integer) RETURNS histogram2d
    AS '$libdir/liblwgeom.so.1.0', 'create_lwhistogram2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.create_histogram2d(box2d, integer) OWNER TO mose;

--
-- Name: crosses(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION crosses(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'crosses'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.crosses(geometry, geometry) OWNER TO mose;

--
-- Name: datatype(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION datatype(chip) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getDatatype'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.datatype(chip) OWNER TO mose;

--
-- Name: difference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION difference(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'difference'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.difference(geometry, geometry) OWNER TO mose;

--
-- Name: dimension(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dimension(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_dimension'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.dimension(geometry) OWNER TO mose;

--
-- Name: disjoint(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION disjoint(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'disjoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.disjoint(geometry, geometry) OWNER TO mose;

--
-- Name: distance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION distance(geometry, geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_mindistance2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.distance(geometry, geometry) OWNER TO mose;

--
-- Name: distance_spheroid(geometry, geometry, spheroid); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION distance_spheroid(geometry, geometry, spheroid) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_distance_ellipsoid_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.distance_spheroid(geometry, geometry, spheroid) OWNER TO mose;

--
-- Name: dropbbox(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropbbox(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_dropBBOX'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.dropbbox(geometry) OWNER TO mose;

--
-- Name: dropgeometrycolumn(character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying) RETURNS text
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	myrec RECORD;
	okay boolean;
	real_schema name;

BEGIN



	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE NOTICE 'Invalid schema name - using current_schema()';
			SELECT current_schema() into real_schema;
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT current_schema() into real_schema;
	END IF;




 	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Remove ref from geometry_columns table
	EXECUTE 'delete from geometry_columns where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);
	
	-- Remove table column
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) || '.' ||
		quote_ident(table_name) || ' DROP COLUMN ' ||
		quote_ident(column_name);



	RETURN real_schema || '.' || table_name || '.' || column_name ||' effectively removed.';
	
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying, character varying) OWNER TO mose;

--
-- Name: dropgeometrycolumn(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying) RETURNS text
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying) OWNER TO mose;

--
-- Name: dropgeometrycolumn(character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying) RETURNS text
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('','',$1,$2) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying) OWNER TO mose;

--
-- Name: dropgeometrytable(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrytable(character varying, character varying, character varying) RETURNS text
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	real_schema name;

BEGIN


	IF ( schema_name = '' ) THEN
		SELECT current_schema() into real_schema;
	ELSE
		real_schema = schema_name;
	END IF;


	-- Remove refs from geometry_columns table
	EXECUTE 'DELETE FROM geometry_columns WHERE ' ||

		'f_table_schema = ' || quote_literal(real_schema) ||
		' AND ' ||

		' f_table_name = ' || quote_literal(table_name);
	
	-- Remove table 
	EXECUTE 'DROP TABLE '

		|| quote_ident(real_schema) || '.' ||

		quote_ident(table_name);

	RETURN

		real_schema || '.' ||

		table_name ||' dropped.';
	
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying, character varying) OWNER TO mose;

--
-- Name: dropgeometrytable(character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrytable(character varying, character varying) RETURNS text
    AS $_$SELECT DropGeometryTable('',$1,$2)$_$
    LANGUAGE sql STRICT;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying) OWNER TO mose;

--
-- Name: dropgeometrytable(character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dropgeometrytable(character varying) RETURNS text
    AS $_$SELECT DropGeometryTable('','',$1)$_$
    LANGUAGE sql STRICT;


ALTER FUNCTION public.dropgeometrytable(character varying) OWNER TO mose;

--
-- Name: dump(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION dump(geometry) RETURNS SETOF geometry_dump
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_dump'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.dump(geometry) OWNER TO mose;

--
-- Name: endpoint(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION endpoint(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_endpoint_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.endpoint(geometry) OWNER TO mose;

--
-- Name: envelope(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION envelope(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_envelope'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.envelope(geometry) OWNER TO mose;

--
-- Name: equals(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION equals(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'geomequals'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.equals(geometry, geometry) OWNER TO mose;

--
-- Name: estimate_histogram2d(histogram2d, box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION estimate_histogram2d(histogram2d, box2d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'estimate_lwhistogram2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.estimate_histogram2d(histogram2d, box2d) OWNER TO mose;

--
-- Name: estimated_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION estimated_extent(text, text, text) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_estimated_extent'
    LANGUAGE c STABLE STRICT;


ALTER FUNCTION public.estimated_extent(text, text, text) OWNER TO mose;

--
-- Name: estimated_extent(text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION estimated_extent(text, text) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_estimated_extent'
    LANGUAGE c STABLE STRICT;


ALTER FUNCTION public.estimated_extent(text, text) OWNER TO mose;

--
-- Name: expand(box3d, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION expand(box3d, double precision) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_expand'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.expand(box3d, double precision) OWNER TO mose;

--
-- Name: expand(box2d, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION expand(box2d, double precision) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_expand'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.expand(box2d, double precision) OWNER TO mose;

--
-- Name: expand(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION expand(geometry, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_expand'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.expand(geometry, double precision) OWNER TO mose;

--
-- Name: explode_histogram2d(histogram2d, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION explode_histogram2d(histogram2d, text) RETURNS histogram2d
    AS '$libdir/liblwgeom.so.1.0', 'explode_lwhistogram2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.explode_histogram2d(histogram2d, text) OWNER TO mose;

--
-- Name: exteriorring(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION exteriorring(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_exteriorring_polygon'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.exteriorring(geometry) OWNER TO mose;

--
-- Name: factor(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION factor(chip) RETURNS real
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getFactor'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.factor(chip) OWNER TO mose;

--
-- Name: find_extent(text, text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION find_extent(text, text, text) RETURNS box2d
    AS $_$
DECLARE
	schemaname alias for $1;
	tablename alias for $2;
	columnname alias for $3;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("'||columnname||'") FROM "'||schemaname||'"."'||tablename||'"' LOOP
		return myrec.extent;
	END LOOP; 
END;
$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.find_extent(text, text, text) OWNER TO mose;

--
-- Name: find_extent(text, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION find_extent(text, text) RETURNS box2d
    AS $_$
DECLARE
	tablename alias for $1;
	columnname alias for $2;
	myrec RECORD;

BEGIN
	FOR myrec IN EXECUTE 'SELECT extent("'||columnname||'") FROM "'||tablename||'"' LOOP
		return myrec.extent;
	END LOOP; 
END;
$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.find_extent(text, text) OWNER TO mose;

--
-- Name: find_srid(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION find_srid(character varying, character varying, character varying) RETURNS integer
    AS $_$DECLARE
   schem text;
   tabl text;
   sr int4;
BEGIN
   IF $1 IS NULL THEN
      RAISE EXCEPTION 'find_srid() - schema is NULL!';
   END IF;
   IF $2 IS NULL THEN
      RAISE EXCEPTION 'find_srid() - table name is NULL!';
   END IF;
   IF $3 IS NULL THEN
      RAISE EXCEPTION 'find_srid() - column name is NULL!';
   END IF;
   schem = $1;
   tabl = $2;
-- if the table contains a . and the schema is empty
-- split the table into a schema and a table
-- otherwise drop through to default behavior
   IF ( schem = '' and tabl LIKE '%.%' ) THEN
     schem = substr(tabl,1,strpos(tabl,'.')-1);
     tabl = substr(tabl,length(schem)+2);
   ELSE
     schem = schem || '%';
   END IF;

   select SRID into sr from geometry_columns where f_table_schema like schem and f_table_name = tabl and f_geometry_column = $3;
   IF NOT FOUND THEN
       RAISE EXCEPTION 'find_srid() - couldnt find the corresponding SRID - is the geometry registered in the GEOMETRY_COLUMNS table?  Is there an uppercase/lowercase missmatch?';
   END IF;
  return sr;
END;
$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.find_srid(character varying, character varying, character varying) OWNER TO mose;

--
-- Name: fix_geometry_columns(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION fix_geometry_columns() RETURNS text
    AS $_$
DECLARE
	mislinked record;
	result text;
	linked integer;
	deleted integer;

	foundschema integer;

BEGIN


	-- Since 7.3 schema support has been added.
	-- Previous postgis versions used to put the database name in
	-- the schema column. This needs to be fixed, so we try to 
	-- set the correct schema for each geometry_colums record
	-- looking at table, column, type and srid.
	UPDATE geometry_columns SET f_table_schema = n.nspname
		FROM pg_namespace n, pg_class c, pg_attribute a,
			pg_constraint sridcheck, pg_constraint typecheck
                WHERE ( f_table_schema is NULL
		OR f_table_schema = ''
                OR f_table_schema NOT IN (
                        SELECT nspname::varchar
                        FROM pg_namespace nn, pg_class cc, pg_attribute aa
                        WHERE cc.relnamespace = nn.oid
                        AND cc.relname = f_table_name::name
                        AND aa.attrelid = cc.oid
                        AND aa.attname = f_geometry_column::name))
                AND f_table_name::name = c.relname
                AND c.oid = a.attrelid
                AND c.relnamespace = n.oid
                AND f_geometry_column::name = a.attname
                AND sridcheck.conrelid = c.oid
                --AND sridcheck.conname = '$1'
		AND sridcheck.consrc LIKE '(srid(% = %)'
                AND typecheck.conrelid = c.oid
                --AND typecheck.conname = '$2'
		AND typecheck.consrc LIKE
	'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
                AND sridcheck.consrc ~ textcat(' = ', srid::text)
                AND typecheck.consrc ~ textcat(' = ''', type::text)
                AND NOT EXISTS (
                        SELECT oid FROM geometry_columns gc
                        WHERE c.relname::varchar = gc.f_table_name

                        AND n.nspname::varchar = gc.f_table_schema

                        AND a.attname::varchar = gc.f_geometry_column
                );

	GET DIAGNOSTICS foundschema = ROW_COUNT;



	-- no linkage to system table needed
	return 'fixed:'||foundschema::text;


	-- fix linking to system tables
	SELECT 0 INTO linked;
	FOR mislinked in
		SELECT gc.oid as gcrec,
			a.attrelid as attrelid, a.attnum as attnum
                FROM geometry_columns gc, pg_class c,

		pg_namespace n, pg_attribute a



                WHERE ( gc.attrelid IS NULL OR gc.attrelid != a.attrelid 
			OR gc.varattnum IS NULL OR gc.varattnum != a.attnum)

                AND n.nspname = gc.f_table_schema::name
                AND c.relnamespace = n.oid

                AND c.relname = gc.f_table_name::name
                AND a.attname = f_geometry_column::name
                AND a.attrelid = c.oid
	LOOP
		UPDATE geometry_columns SET
			attrelid = mislinked.attrelid,
			varattnum = mislinked.attnum,
			stats = NULL
			WHERE geometry_columns.oid = mislinked.gcrec;
		SELECT linked+1 INTO linked;
	END LOOP; 

	-- remove stale records
	DELETE FROM geometry_columns WHERE attrelid IS NULL;

	GET DIAGNOSTICS deleted = ROW_COUNT;

	result = 

		'fixed:' || foundschema::text ||

		' linked:' || linked::text || 
		' deleted:' || deleted::text;

	return result;

END;
$_$
    LANGUAGE plpgsql;


ALTER FUNCTION public.fix_geometry_columns() OWNER TO mose;

--
-- Name: force_2d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_2d(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_2d(geometry) OWNER TO mose;

--
-- Name: force_3d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_3d(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_3dz'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_3d(geometry) OWNER TO mose;

--
-- Name: force_3dm(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_3dm(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_3dm'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_3dm(geometry) OWNER TO mose;

--
-- Name: force_3dz(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_3dz(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_3dz'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_3dz(geometry) OWNER TO mose;

--
-- Name: force_4d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_4d(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_4d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_4d(geometry) OWNER TO mose;

--
-- Name: force_collection(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION force_collection(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_collection'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.force_collection(geometry) OWNER TO mose;

--
-- Name: forcerhr(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION forcerhr(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_forceRHR_poly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.forcerhr(geometry) OWNER TO mose;

--
-- Name: geom_accum(geometry[], geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geom_accum(geometry[], geometry) RETURNS geometry[]
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_accum'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.geom_accum(geometry[], geometry) OWNER TO mose;

--
-- Name: geomcollfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomcollfromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomcollfromtext(text, integer) OWNER TO mose;

--
-- Name: geomcollfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomcollfromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomcollfromtext(text) OWNER TO mose;

--
-- Name: geomcollfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomcollfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromWKB($1, $2)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomcollfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: geomcollfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomcollfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromWKB($1)) = 'GEOMETRYCOLLECTION'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomcollfromwkb(bytea) OWNER TO mose;

--
-- Name: geometry(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry(box2d) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_to_LWGEOM'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry(box2d) OWNER TO mose;

--
-- Name: geometry(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry(box3d) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_to_LWGEOM'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry(box3d) OWNER TO mose;

--
-- Name: geometry(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry(text) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'parse_WKT_lwgeom'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry(text) OWNER TO mose;

--
-- Name: geometry(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry(chip) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_to_LWGEOM'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry(chip) OWNER TO mose;

--
-- Name: geometry(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry(bytea) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_from_bytea'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry(bytea) OWNER TO mose;

--
-- Name: geometry_above(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_above(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_above'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_above(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_below(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_below(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_below'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_below(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_cmp(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_cmp(geometry, geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_cmp'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_cmp(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_contain(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_contain(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_contain'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_contain(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_contained(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_contained(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_contained'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_contained(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_eq(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_eq(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_eq'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_eq(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_ge(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_ge(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_ge'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_ge(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_gt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_gt(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_gt'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_gt(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_le(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_le(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_le'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_le(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_left(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_left(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_left'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_left(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_lt(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_lt(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'lwgeom_lt'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_lt(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_overabove(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_overabove(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_overabove'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_overabove(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_overbelow(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_overbelow(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_overbelow'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_overbelow(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_overlap(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_overlap(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_overlap'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_overlap(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_overleft(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_overleft(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_overleft'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_overleft(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_overright(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_overright(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_overright'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_overright(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_right(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_right(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_right'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_right(geometry, geometry) OWNER TO mose;

--
-- Name: geometry_same(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometry_same(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_same'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometry_same(geometry, geometry) OWNER TO mose;

--
-- Name: geometryfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometryfromtext(text) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_from_text'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometryfromtext(text) OWNER TO mose;

--
-- Name: geometryfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometryfromtext(text, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_from_text'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometryfromtext(text, integer) OWNER TO mose;

--
-- Name: geometryn(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometryn(geometry, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_geometryn_collection'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometryn(geometry, integer) OWNER TO mose;

--
-- Name: geometrytype(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geometrytype(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_getTYPE'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geometrytype(geometry) OWNER TO mose;

--
-- Name: geomfromewkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromewkb(bytea) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOMFromWKB'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromewkb(bytea) OWNER TO mose;

--
-- Name: geomfromewkt(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromewkt(text) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'parse_WKT_lwgeom'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromewkt(text) OWNER TO mose;

--
-- Name: geomfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromtext(text) RETURNS geometry
    AS $_$SELECT geometryfromtext($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromtext(text) OWNER TO mose;

--
-- Name: geomfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromtext(text, integer) RETURNS geometry
    AS $_$SELECT geometryfromtext($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromtext(text, integer) OWNER TO mose;

--
-- Name: geomfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromwkb(bytea) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_from_WKB'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromwkb(bytea) OWNER TO mose;

--
-- Name: geomfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomfromwkb(bytea, integer) RETURNS geometry
    AS $_$SELECT setSRID(GeomFromWKB($1), $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.geomfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: geomunion(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geomunion(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'geomunion'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.geomunion(geometry, geometry) OWNER TO mose;

--
-- Name: geosnoop(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION geosnoop(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'GEOSnoop'
    LANGUAGE c STRICT;


ALTER FUNCTION public.geosnoop(geometry) OWNER TO mose;

--
-- Name: get_proj4_from_srid(integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION get_proj4_from_srid(integer) RETURNS text
    AS $_$SELECT proj4text::text FROM spatial_ref_sys WHERE srid= $1$_$
    LANGUAGE sql STABLE STRICT;


ALTER FUNCTION public.get_proj4_from_srid(integer) OWNER TO mose;

--
-- Name: getbbox(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION getbbox(geometry) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_BOX2DFLOAT4'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.getbbox(geometry) OWNER TO mose;

--
-- Name: getsrid(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION getsrid(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_getSRID'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.getsrid(geometry) OWNER TO mose;

--
-- Name: hasbbox(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION hasbbox(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_hasBBOX'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.hasbbox(geometry) OWNER TO mose;

--
-- Name: height(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION height(chip) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getHeight'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.height(chip) OWNER TO mose;

--
-- Name: interiorringn(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION interiorringn(geometry, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_interiorringn_polygon'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.interiorringn(geometry, integer) OWNER TO mose;

--
-- Name: intersection(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION intersection(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'intersection'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.intersection(geometry, geometry) OWNER TO mose;

--
-- Name: intersects(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION intersects(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'intersects'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.intersects(geometry, geometry) OWNER TO mose;

--
-- Name: isclosed(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION isclosed(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_isclosed_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.isclosed(geometry) OWNER TO mose;

--
-- Name: isempty(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION isempty(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_isempty'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.isempty(geometry) OWNER TO mose;

--
-- Name: isring(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION isring(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'isring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.isring(geometry) OWNER TO mose;

--
-- Name: issimple(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION issimple(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'issimple'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.issimple(geometry) OWNER TO mose;

--
-- Name: isvalid(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION isvalid(geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'isvalid'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.isvalid(geometry) OWNER TO mose;

--
-- Name: length(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length(geometry) OWNER TO mose;

--
-- Name: length2d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length2d(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length2d_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length2d(geometry) OWNER TO mose;

--
-- Name: length2d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length2d_spheroid(geometry, spheroid) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length2d_ellipsoid_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length2d_spheroid(geometry, spheroid) OWNER TO mose;

--
-- Name: length3d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length3d(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length3d(geometry) OWNER TO mose;

--
-- Name: length3d_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length3d_spheroid(geometry, spheroid) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length_ellipsoid_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length3d_spheroid(geometry, spheroid) OWNER TO mose;

--
-- Name: length_spheroid(geometry, spheroid); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION length_spheroid(geometry, spheroid) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_length_ellipsoid_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.length_spheroid(geometry, spheroid) OWNER TO mose;

--
-- Name: line_interpolate_point(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION line_interpolate_point(geometry, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_line_interpolate_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.line_interpolate_point(geometry, double precision) OWNER TO mose;

--
-- Name: linefrommultipoint(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linefrommultipoint(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_line_from_mpoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.linefrommultipoint(geometry) OWNER TO mose;

--
-- Name: linefromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linefromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'LINESTRING'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linefromtext(text) OWNER TO mose;

--
-- Name: linefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linefromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'LINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linefromtext(text, integer) OWNER TO mose;

--
-- Name: linefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linefromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linefromwkb(bytea, integer) OWNER TO mose;

--
-- Name: linefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linefromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'LINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linefromwkb(bytea) OWNER TO mose;

--
-- Name: linestringfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linestringfromtext(text) RETURNS geometry
    AS $_$SELECT LineFromText($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linestringfromtext(text) OWNER TO mose;

--
-- Name: linestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linestringfromtext(text, integer) RETURNS geometry
    AS $_$SELECT LineFromText($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linestringfromtext(text, integer) OWNER TO mose;

--
-- Name: linestringfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linestringfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'LINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linestringfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: linestringfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION linestringfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'LINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.linestringfromwkb(bytea) OWNER TO mose;

--
-- Name: lwgeom_gist_compress(internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_compress(internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_compress'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_compress(internal) OWNER TO mose;

--
-- Name: lwgeom_gist_consistent(internal, geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_consistent(internal, geometry, integer) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_consistent'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_consistent(internal, geometry, integer) OWNER TO mose;

--
-- Name: lwgeom_gist_decompress(internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_decompress(internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_decompress'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_decompress(internal) OWNER TO mose;

--
-- Name: lwgeom_gist_penalty(internal, internal, internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_penalty(internal, internal, internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_penalty'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_penalty(internal, internal, internal) OWNER TO mose;

--
-- Name: lwgeom_gist_picksplit(internal, internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_picksplit(internal, internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_picksplit'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_picksplit(internal, internal) OWNER TO mose;

--
-- Name: lwgeom_gist_same(box2d, box2d, internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_same(box2d, box2d, internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_same'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_same(box2d, box2d, internal) OWNER TO mose;

--
-- Name: lwgeom_gist_union(bytea, internal); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION lwgeom_gist_union(bytea, internal) RETURNS internal
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_union'
    LANGUAGE c;


ALTER FUNCTION public.lwgeom_gist_union(bytea, internal) OWNER TO mose;

--
-- Name: makebox2d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makebox2d(geometry, geometry) RETURNS box2d
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_construct'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makebox2d(geometry, geometry) OWNER TO mose;

--
-- Name: makebox3d(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makebox3d(geometry, geometry) RETURNS box3d
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_construct'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makebox3d(geometry, geometry) OWNER TO mose;

--
-- Name: makeline(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makeline(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makeline'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makeline(geometry, geometry) OWNER TO mose;

--
-- Name: makeline_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makeline_garray(geometry[]) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makeline_garray'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makeline_garray(geometry[]) OWNER TO mose;

--
-- Name: makepoint(double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepoint(double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepoint(double precision, double precision) OWNER TO mose;

--
-- Name: makepoint(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepoint(double precision, double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepoint(double precision, double precision, double precision) OWNER TO mose;

--
-- Name: makepoint(double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepoint(double precision, double precision, double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoint'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepoint(double precision, double precision, double precision, double precision) OWNER TO mose;

--
-- Name: makepointm(double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepointm(double precision, double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoint3dm'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepointm(double precision, double precision, double precision) OWNER TO mose;

--
-- Name: makepolygon(geometry, geometry[]); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepolygon(geometry, geometry[]) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepolygon(geometry, geometry[]) OWNER TO mose;

--
-- Name: makepolygon(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION makepolygon(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_makepoly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.makepolygon(geometry) OWNER TO mose;

--
-- Name: max_distance(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION max_distance(geometry, geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_maxdistance2d_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.max_distance(geometry, geometry) OWNER TO mose;

--
-- Name: mem_size(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mem_size(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_mem_size'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.mem_size(geometry) OWNER TO mose;

--
-- Name: mlinefromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mlinefromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE
	WHEN geometrytype(GeomFromText($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mlinefromtext(text, integer) OWNER TO mose;

--
-- Name: mlinefromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mlinefromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTILINESTRING'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mlinefromtext(text) OWNER TO mose;

--
-- Name: mlinefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mlinefromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mlinefromwkb(bytea, integer) OWNER TO mose;

--
-- Name: mlinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mlinefromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mlinefromwkb(bytea) OWNER TO mose;

--
-- Name: mpointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpointfromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1,$2)) = 'MULTIPOINT'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpointfromtext(text, integer) OWNER TO mose;

--
-- Name: mpointfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpointfromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTIPOINT'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpointfromtext(text) OWNER TO mose;

--
-- Name: mpointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpointfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'MULTIPOINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpointfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: mpointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpointfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpointfromwkb(bytea) OWNER TO mose;

--
-- Name: mpolyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpolyfromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpolyfromtext(text, integer) OWNER TO mose;

--
-- Name: mpolyfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpolyfromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'MULTIPOLYGON'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpolyfromtext(text) OWNER TO mose;

--
-- Name: mpolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpolyfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpolyfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: mpolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION mpolyfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.mpolyfromwkb(bytea) OWNER TO mose;

--
-- Name: multi(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multi(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_force_multi'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.multi(geometry) OWNER TO mose;

--
-- Name: multilinefromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multilinefromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multilinefromwkb(bytea, integer) OWNER TO mose;

--
-- Name: multilinefromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multilinefromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTILINESTRING'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multilinefromwkb(bytea) OWNER TO mose;

--
-- Name: multilinestringfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multilinestringfromtext(text) RETURNS geometry
    AS $_$SELECT MLineFromText($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multilinestringfromtext(text) OWNER TO mose;

--
-- Name: multilinestringfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multilinestringfromtext(text, integer) RETURNS geometry
    AS $_$SELECT MLineFromText($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multilinestringfromtext(text, integer) OWNER TO mose;

--
-- Name: multipointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipointfromtext(text, integer) RETURNS geometry
    AS $_$SELECT MPointFromText($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipointfromtext(text, integer) OWNER TO mose;

--
-- Name: multipointfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipointfromtext(text) RETURNS geometry
    AS $_$SELECT MPointFromText($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipointfromtext(text) OWNER TO mose;

--
-- Name: multipointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipointfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'MULTIPOINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipointfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: multipointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipointfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipointfromwkb(bytea) OWNER TO mose;

--
-- Name: multipolyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipolyfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipolyfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: multipolyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipolyfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'MULTIPOLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipolyfromwkb(bytea) OWNER TO mose;

--
-- Name: multipolygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipolygonfromtext(text, integer) RETURNS geometry
    AS $_$SELECT MPolyFromText($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipolygonfromtext(text, integer) OWNER TO mose;

--
-- Name: multipolygonfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION multipolygonfromtext(text) RETURNS geometry
    AS $_$SELECT MPolyFromText($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.multipolygonfromtext(text) OWNER TO mose;

--
-- Name: ndims(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION ndims(geometry) RETURNS smallint
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_ndims'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.ndims(geometry) OWNER TO mose;

--
-- Name: noop(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION noop(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_noop'
    LANGUAGE c STRICT;


ALTER FUNCTION public.noop(geometry) OWNER TO mose;

--
-- Name: npoints(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION npoints(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_npoints'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.npoints(geometry) OWNER TO mose;

--
-- Name: nrings(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION nrings(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_nrings'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.nrings(geometry) OWNER TO mose;

--
-- Name: numgeometries(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION numgeometries(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_numgeometries_collection'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.numgeometries(geometry) OWNER TO mose;

--
-- Name: numinteriorrings(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION numinteriorrings(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_numinteriorrings_polygon'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.numinteriorrings(geometry) OWNER TO mose;

--
-- Name: numpoints(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION numpoints(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_numpoints_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.numpoints(geometry) OWNER TO mose;

--
-- Name: overlaps(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION "overlaps"(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'overlaps'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public."overlaps"(geometry, geometry) OWNER TO mose;

--
-- Name: perimeter(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION perimeter(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_perimeter_poly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.perimeter(geometry) OWNER TO mose;

--
-- Name: perimeter2d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION perimeter2d(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_perimeter2d_poly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.perimeter2d(geometry) OWNER TO mose;

--
-- Name: perimeter3d(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION perimeter3d(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_perimeter_poly'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.perimeter3d(geometry) OWNER TO mose;

--
-- Name: point_inside_circle(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION point_inside_circle(geometry, double precision, double precision, double precision) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_inside_circle_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.point_inside_circle(geometry, double precision, double precision, double precision) OWNER TO mose;

--
-- Name: pointfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointfromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'POINT'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.pointfromtext(text) OWNER TO mose;

--
-- Name: pointfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointfromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'POINT'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.pointfromtext(text, integer) OWNER TO mose;

--
-- Name: pointfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'POINT'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.pointfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: pointfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POINT'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.pointfromwkb(bytea) OWNER TO mose;

--
-- Name: pointn(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointn(geometry, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_pointn_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.pointn(geometry, integer) OWNER TO mose;

--
-- Name: pointonsurface(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION pointonsurface(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'pointonsurface'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.pointonsurface(geometry) OWNER TO mose;

--
-- Name: polyfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polyfromtext(text) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1)) = 'POLYGON'
	THEN GeomFromText($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polyfromtext(text) OWNER TO mose;

--
-- Name: polyfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polyfromtext(text, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromText($1, $2)) = 'POLYGON'
	THEN GeomFromText($1,$2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polyfromtext(text, integer) OWNER TO mose;

--
-- Name: polyfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polyfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1, $2)) = 'POLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polyfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: polyfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polyfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polyfromwkb(bytea) OWNER TO mose;

--
-- Name: polygonfromtext(text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polygonfromtext(text, integer) RETURNS geometry
    AS $_$SELECT PolyFromText($1, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polygonfromtext(text, integer) OWNER TO mose;

--
-- Name: polygonfromtext(text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polygonfromtext(text) RETURNS geometry
    AS $_$SELECT PolyFromText($1)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polygonfromtext(text) OWNER TO mose;

--
-- Name: polygonfromwkb(bytea, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polygonfromwkb(bytea, integer) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1,$2)) = 'POLYGON'
	THEN GeomFromWKB($1, $2)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polygonfromwkb(bytea, integer) OWNER TO mose;

--
-- Name: polygonfromwkb(bytea); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polygonfromwkb(bytea) RETURNS geometry
    AS $_$
	SELECT CASE WHEN geometrytype(GeomFromWKB($1)) = 'POLYGON'
	THEN GeomFromWKB($1)
	ELSE NULL END
	$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.polygonfromwkb(bytea) OWNER TO mose;

--
-- Name: polygonize_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION polygonize_garray(geometry[]) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'GEOS_polygonize_garray'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.polygonize_garray(geometry[]) OWNER TO mose;

--
-- Name: postgis_full_version(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_full_version() RETURNS text
    AS $$
DECLARE
	libver text;
	projver text;
	geosver text;
	usestats bool;
	dbproc text;
	relproc text;
	fullver text;
BEGIN
	SELECT postgis_lib_version() INTO libver;
	SELECT postgis_proj_version() INTO projver;
	SELECT postgis_geos_version() INTO geosver;
	SELECT postgis_uses_stats() INTO usestats;
	SELECT postgis_scripts_installed() INTO dbproc;
	SELECT postgis_scripts_released() INTO relproc;

	fullver = 'POSTGIS="' || libver || '"';

	IF  geosver IS NOT NULL THEN
		fullver = fullver || ' GEOS="' || geosver || '"';
	END IF;

	IF  projver IS NOT NULL THEN
		fullver = fullver || ' PROJ="' || projver || '"';
	END IF;

	IF usestats THEN
		fullver = fullver || ' USE_STATS';
	END IF;

	fullver = fullver || ' DBPROC="' || dbproc || '"';
	fullver = fullver || ' RELPROC="' || relproc || '"';

	IF dbproc != relproc THEN
		fullver = fullver || ' (needs proc upgrade)';
	END IF;

	RETURN fullver;
END
$$
    LANGUAGE plpgsql STABLE;


ALTER FUNCTION public.postgis_full_version() OWNER TO mose;

--
-- Name: postgis_geos_version(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_geos_version() RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'postgis_geos_version'
    LANGUAGE c STABLE;


ALTER FUNCTION public.postgis_geos_version() OWNER TO mose;

--
-- Name: postgis_gist_joinsel(internal, oid, internal, smallint); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_gist_joinsel(internal, oid, internal, smallint) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_joinsel'
    LANGUAGE c;


ALTER FUNCTION public.postgis_gist_joinsel(internal, oid, internal, smallint) OWNER TO mose;

--
-- Name: postgis_gist_sel(internal, oid, internal, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_gist_sel(internal, oid, internal, integer) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_gist_sel'
    LANGUAGE c;


ALTER FUNCTION public.postgis_gist_sel(internal, oid, internal, integer) OWNER TO mose;

--
-- Name: postgis_lib_build_date(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_lib_build_date() RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'postgis_lib_build_date'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.postgis_lib_build_date() OWNER TO mose;

--
-- Name: postgis_lib_version(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_lib_version() RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'postgis_lib_version'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.postgis_lib_version() OWNER TO mose;

--
-- Name: postgis_proj_version(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_proj_version() RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'postgis_proj_version'
    LANGUAGE c STABLE;


ALTER FUNCTION public.postgis_proj_version() OWNER TO mose;

--
-- Name: postgis_scripts_build_date(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_scripts_build_date() RETURNS text
    AS $$SELECT '2005-01-30 18:23:00'::text AS version$$
    LANGUAGE sql IMMUTABLE;


ALTER FUNCTION public.postgis_scripts_build_date() OWNER TO mose;

--
-- Name: postgis_scripts_installed(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_scripts_installed() RETURNS text
    AS $$SELECT '0.1.0'::text AS version$$
    LANGUAGE sql IMMUTABLE;


ALTER FUNCTION public.postgis_scripts_installed() OWNER TO mose;

--
-- Name: postgis_scripts_released(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_scripts_released() RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'postgis_scripts_released'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.postgis_scripts_released() OWNER TO mose;

--
-- Name: postgis_uses_stats(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_uses_stats() RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'postgis_uses_stats'
    LANGUAGE c IMMUTABLE;


ALTER FUNCTION public.postgis_uses_stats() OWNER TO mose;

--
-- Name: postgis_version(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION postgis_version() RETURNS text
    AS $$SELECT '1.0 USE_GEOS=1 USE_PROJ=1 USE_STATS=1'::text AS version$$
    LANGUAGE sql IMMUTABLE;


ALTER FUNCTION public.postgis_version() OWNER TO mose;

--
-- Name: probe_geometry_columns(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION probe_geometry_columns() RETURNS text
    AS $_$
DECLARE
	inserted integer;
	oldcount integer;
	probed integer;
	stale integer;
BEGIN

	SELECT count(*) INTO oldcount FROM geometry_columns;

	SELECT count(*) INTO probed
		FROM pg_class c, pg_attribute a, pg_type t, 

			pg_namespace n,

			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid

		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid

		AND sridcheck.conrelid = c.oid
		--AND sridcheck.conname = '$1'
		AND sridcheck.consrc LIKE '(srid(% = %)'
		AND typecheck.conrelid = c.oid
		--AND typecheck.conname = '$2';
		AND typecheck.consrc LIKE
	'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
		;

	INSERT INTO geometry_columns SELECT
		''::varchar as f_table_catalogue,

		n.nspname::varchar as f_table_schema,



		c.relname::varchar as f_table_name,
		a.attname::varchar as f_geometry_column,
		2 as coord_dimension,
		trim(both  ' =)' from substr(sridcheck.consrc,
			strpos(sridcheck.consrc, '=')))::integer as srid,
		trim(both ' =)''' from substr(typecheck.consrc, 
			strpos(typecheck.consrc, '='),
			strpos(typecheck.consrc, '::')-
			strpos(typecheck.consrc, '=')
			))::varchar as type





		FROM pg_class c, pg_attribute a, pg_type t, 

			pg_namespace n,

			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid

		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid

		AND sridcheck.conrelid = c.oid
		--AND sridcheck.conname = '$1'
		AND sridcheck.consrc LIKE '(srid(% = %)'
		AND typecheck.conrelid = c.oid
		--AND typecheck.conname = '$2'
		AND typecheck.consrc LIKE
	'((geometrytype(%) = ''%''::text) OR (% IS NULL))'

                AND NOT EXISTS (
                        SELECT oid FROM geometry_columns gc
                        WHERE c.relname::varchar = gc.f_table_name

                        AND n.nspname::varchar = gc.f_table_schema

                        AND a.attname::varchar = gc.f_geometry_column
                );

	GET DIAGNOSTICS inserted = ROW_COUNT;

	IF oldcount > probed THEN
		stale = oldcount-probed;
	ELSE
		stale = 0;
	END IF;

        RETURN 'probed:'||probed||
		' inserted:'||inserted||
		' conflicts:'||probed-inserted||
		' stale:'||stale;
END

$_$
    LANGUAGE plpgsql;


ALTER FUNCTION public.probe_geometry_columns() OWNER TO mose;

--
-- Name: relate(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION relate(geometry, geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'relate_full'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.relate(geometry, geometry) OWNER TO mose;

--
-- Name: relate(geometry, geometry, text); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION relate(geometry, geometry, text) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'relate_pattern'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.relate(geometry, geometry, text) OWNER TO mose;

--
-- Name: rename_geometry_table_constraints(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION rename_geometry_table_constraints() RETURNS text
    AS $$
SELECT 'rename_geometry_table_constraint() is obsoleted'::text
$$
    LANGUAGE sql IMMUTABLE;


ALTER FUNCTION public.rename_geometry_table_constraints() OWNER TO mose;

--
-- Name: reverse(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION reverse(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_reverse'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.reverse(geometry) OWNER TO mose;

--
-- Name: segmentize(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION segmentize(geometry, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_segmentize2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.segmentize(geometry, double precision) OWNER TO mose;

--
-- Name: setfactor(chip, real); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION setfactor(chip, real) RETURNS chip
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_setFactor'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.setfactor(chip, real) OWNER TO mose;

--
-- Name: setsrid(chip, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION setsrid(chip, integer) RETURNS chip
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_setSRID'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.setsrid(chip, integer) OWNER TO mose;

--
-- Name: setsrid(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION setsrid(geometry, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_setSRID'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.setsrid(geometry, integer) OWNER TO mose;

--
-- Name: simplify(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION simplify(geometry, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_simplify2d'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.simplify(geometry, double precision) OWNER TO mose;

--
-- Name: snaptogrid(geometry, double precision, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION snaptogrid(geometry, double precision, double precision, double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_snaptogrid'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.snaptogrid(geometry, double precision, double precision, double precision, double precision) OWNER TO mose;

--
-- Name: snaptogrid(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION snaptogrid(geometry, double precision, double precision) RETURNS geometry
    AS $_$SELECT SnapToGrid($1, 0, 0, $2, $3)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.snaptogrid(geometry, double precision, double precision) OWNER TO mose;

--
-- Name: snaptogrid(geometry, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION snaptogrid(geometry, double precision) RETURNS geometry
    AS $_$SELECT SnapToGrid($1, 0, 0, $2, $2)$_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.snaptogrid(geometry, double precision) OWNER TO mose;

--
-- Name: srid(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION srid(chip) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getSRID'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.srid(chip) OWNER TO mose;

--
-- Name: srid(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION srid(geometry) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_getSRID'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.srid(geometry) OWNER TO mose;

--
-- Name: startpoint(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION startpoint(geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_startpoint_linestring'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.startpoint(geometry) OWNER TO mose;

--
-- Name: summary(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION summary(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_summary'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.summary(geometry) OWNER TO mose;

--
-- Name: symdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION symdifference(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'symdifference'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.symdifference(geometry, geometry) OWNER TO mose;

--
-- Name: symmetricdifference(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION symmetricdifference(geometry, geometry) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'symdifference'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.symmetricdifference(geometry, geometry) OWNER TO mose;

--
-- Name: text(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION text(geometry) RETURNS text
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_to_text'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.text(geometry) OWNER TO mose;

--
-- Name: touches(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION touches(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'touches'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.touches(geometry, geometry) OWNER TO mose;

--
-- Name: transform(geometry, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION transform(geometry, integer) RETURNS geometry
    AS $_$BEGIN
 RETURN transform_geometry( $1 , get_proj4_from_srid(SRID( $1 ) ), get_proj4_from_srid( $2 ), $2 );
 END;$_$
    LANGUAGE plpgsql STABLE STRICT;


ALTER FUNCTION public.transform(geometry, integer) OWNER TO mose;

--
-- Name: transform_geometry(geometry, text, text, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION transform_geometry(geometry, text, text, integer) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'transform_geom'
    LANGUAGE c STABLE STRICT;


ALTER FUNCTION public.transform_geometry(geometry, text, text, integer) OWNER TO mose;

--
-- Name: translate(geometry, double precision, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION translate(geometry, double precision, double precision, double precision) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_translate'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.translate(geometry, double precision, double precision, double precision) OWNER TO mose;

--
-- Name: translate(geometry, double precision, double precision); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION translate(geometry, double precision, double precision) RETURNS geometry
    AS $_$ SELECT translate($1, $2, $3, 0) $_$
    LANGUAGE sql IMMUTABLE STRICT;


ALTER FUNCTION public.translate(geometry, double precision, double precision) OWNER TO mose;

--
-- Name: unite_garray(geometry[]); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION unite_garray(geometry[]) RETURNS geometry
    AS '$libdir/liblwgeom.so.1.0', 'unite_garray'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.unite_garray(geometry[]) OWNER TO mose;

--
-- Name: update_geometry_stats(); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION update_geometry_stats() RETURNS text
    AS $$ SELECT 'update_geometry_stats() has been obsoleted. Statistics are automatically built running the ANALYZE command'::text$$
    LANGUAGE sql;


ALTER FUNCTION public.update_geometry_stats() OWNER TO mose;

--
-- Name: update_geometry_stats(character varying, character varying); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION update_geometry_stats(character varying, character varying) RETURNS text
    AS $$SELECT update_geometry_stats();$$
    LANGUAGE sql;


ALTER FUNCTION public.update_geometry_stats(character varying, character varying) OWNER TO mose;

--
-- Name: updategeometrysrid(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer) RETURNS text
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	myrec RECORD;
	okay boolean;
	cname varchar;
	real_schema name;

BEGIN



	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE EXCEPTION 'Invalid schema name';
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT INTO real_schema current_schema()::text;
	END IF;


 	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Update ref from geometry_columns table
	EXECUTE 'UPDATE geometry_columns SET SRID = ' || new_srid || 
		' where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);
	
	-- Make up constraint name
	cname = 'enforce_srid_'  || column_name;

	-- Drop enforce_srid constraint



	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||

		' DROP constraint ' || quote_ident(cname);

	-- Update geometries SRID



	EXECUTE 'UPDATE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||

		' SET ' || quote_ident(column_name) ||
		' = setSRID(' || quote_ident(column_name) ||
		', ' || new_srid || ')';

	-- Reset enforce_srid constraint



	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||

		' ADD constraint ' || quote_ident(cname) ||
		' CHECK (srid(' || quote_ident(column_name) ||
		') = ' || new_srid || ')';

	RETURN real_schema || '.' || table_name || '.' || column_name ||' SRID changed to ' || new_srid;
	
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, character varying, integer) OWNER TO mose;

--
-- Name: updategeometrysrid(character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, integer) RETURNS text
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('',$1,$2,$3,$4) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, integer) OWNER TO mose;

--
-- Name: updategeometrysrid(character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, integer) RETURNS text
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('','',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$
    LANGUAGE plpgsql STRICT;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, integer) OWNER TO mose;

--
-- Name: width(chip); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION width(chip) RETURNS integer
    AS '$libdir/liblwgeom.so.1.0', 'CHIP_getWidth'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.width(chip) OWNER TO mose;

--
-- Name: within(geometry, geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION within(geometry, geometry) RETURNS boolean
    AS '$libdir/liblwgeom.so.1.0', 'within'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.within(geometry, geometry) OWNER TO mose;

--
-- Name: x(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION x(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_x_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.x(geometry) OWNER TO mose;

--
-- Name: xmax(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION xmax(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_xmax'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.xmax(box3d) OWNER TO mose;

--
-- Name: xmax(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION xmax(box2d) RETURNS real
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_xmax'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.xmax(box2d) OWNER TO mose;

--
-- Name: xmin(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION xmin(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_xmin'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.xmin(box3d) OWNER TO mose;

--
-- Name: xmin(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION xmin(box2d) RETURNS real
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_xmin'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.xmin(box2d) OWNER TO mose;

--
-- Name: y(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION y(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_y_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.y(geometry) OWNER TO mose;

--
-- Name: ymax(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION ymax(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_ymax'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.ymax(box3d) OWNER TO mose;

--
-- Name: ymax(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION ymax(box2d) RETURNS real
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_ymax'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.ymax(box2d) OWNER TO mose;

--
-- Name: ymin(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION ymin(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_ymin'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.ymin(box3d) OWNER TO mose;

--
-- Name: ymin(box2d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION ymin(box2d) RETURNS real
    AS '$libdir/liblwgeom.so.1.0', 'BOX2DFLOAT4_ymin'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.ymin(box2d) OWNER TO mose;

--
-- Name: z(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION z(geometry) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_z_point'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.z(geometry) OWNER TO mose;

--
-- Name: zmax(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION zmax(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_zmax'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.zmax(box3d) OWNER TO mose;

--
-- Name: zmflag(geometry); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION zmflag(geometry) RETURNS smallint
    AS '$libdir/liblwgeom.so.1.0', 'LWGEOM_zmflag'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.zmflag(geometry) OWNER TO mose;

--
-- Name: zmin(box3d); Type: FUNCTION; Schema: public; Owner: mose
--

CREATE FUNCTION zmin(box3d) RETURNS double precision
    AS '$libdir/liblwgeom.so.1.0', 'BOX3D_zmin'
    LANGUAGE c IMMUTABLE STRICT;


ALTER FUNCTION public.zmin(box3d) OWNER TO mose;

--
-- Name: accum(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE accum (
    BASETYPE = geometry,
    SFUNC = geom_accum,
    STYPE = geometry[]
);


ALTER AGGREGATE public.accum(geometry) OWNER TO mose;

--
-- Name: collect(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE collect (
    BASETYPE = geometry,
    SFUNC = geom_accum,
    STYPE = geometry[],
    FINALFUNC = collect_garray
);


ALTER AGGREGATE public.collect(geometry) OWNER TO mose;

--
-- Name: extent(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE extent (
    BASETYPE = geometry,
    SFUNC = public.combine_bbox,
    STYPE = box2d
);


ALTER AGGREGATE public.extent(geometry) OWNER TO mose;

--
-- Name: extent3d(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE extent3d (
    BASETYPE = geometry,
    SFUNC = public.combine_bbox,
    STYPE = box3d
);


ALTER AGGREGATE public.extent3d(geometry) OWNER TO mose;

--
-- Name: geomunion(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE geomunion (
    BASETYPE = geometry,
    SFUNC = geom_accum,
    STYPE = geometry[],
    FINALFUNC = unite_garray
);


ALTER AGGREGATE public.geomunion(geometry) OWNER TO mose;

--
-- Name: makeline(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE makeline (
    BASETYPE = geometry,
    SFUNC = geom_accum,
    STYPE = geometry[],
    FINALFUNC = makeline_garray
);


ALTER AGGREGATE public.makeline(geometry) OWNER TO mose;

--
-- Name: memcollect(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE memcollect (
    BASETYPE = geometry,
    SFUNC = public.collect,
    STYPE = geometry
);


ALTER AGGREGATE public.memcollect(geometry) OWNER TO mose;

--
-- Name: memgeomunion(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE memgeomunion (
    BASETYPE = geometry,
    SFUNC = public.geomunion,
    STYPE = geometry
);


ALTER AGGREGATE public.memgeomunion(geometry) OWNER TO mose;

--
-- Name: polygonize(geometry); Type: AGGREGATE; Schema: public; Owner: mose
--

CREATE AGGREGATE polygonize (
    BASETYPE = geometry,
    SFUNC = geom_accum,
    STYPE = geometry[],
    FINALFUNC = polygonize_garray
);


ALTER AGGREGATE public.polygonize(geometry) OWNER TO mose;

--
-- Name: &&; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR && (
    PROCEDURE = geometry_overlap,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &&,
    RESTRICT = postgis_gist_sel,
    JOIN = postgis_gist_joinsel
);


ALTER OPERATOR public.&& (geometry, geometry) OWNER TO mose;

--
-- Name: &<; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR &< (
    PROCEDURE = geometry_overleft,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&< (geometry, geometry) OWNER TO mose;

--
-- Name: &<|; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR &<| (
    PROCEDURE = geometry_overbelow,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = |&>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&<| (geometry, geometry) OWNER TO mose;

--
-- Name: &>; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR &> (
    PROCEDURE = geometry_overright,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &<,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.&> (geometry, geometry) OWNER TO mose;

--
-- Name: <; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR < (
    PROCEDURE = geometry_lt,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >,
    NEGATOR = >=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.< (geometry, geometry) OWNER TO mose;

--
-- Name: <<; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR << (
    PROCEDURE = geometry_left,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.<< (geometry, geometry) OWNER TO mose;

--
-- Name: <<|; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR <<| (
    PROCEDURE = geometry_below,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = |>>,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.<<| (geometry, geometry) OWNER TO mose;

--
-- Name: <=; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR <= (
    PROCEDURE = geometry_le,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = >=,
    NEGATOR = >,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.<= (geometry, geometry) OWNER TO mose;

--
-- Name: =; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR = (
    PROCEDURE = geometry_eq,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = =,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.= (geometry, geometry) OWNER TO mose;

--
-- Name: >; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR > (
    PROCEDURE = geometry_gt,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <,
    NEGATOR = <=,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.> (geometry, geometry) OWNER TO mose;

--
-- Name: >=; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR >= (
    PROCEDURE = geometry_ge,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <=,
    NEGATOR = <,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.>= (geometry, geometry) OWNER TO mose;

--
-- Name: >>; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR >> (
    PROCEDURE = geometry_right,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <<,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.>> (geometry, geometry) OWNER TO mose;

--
-- Name: @; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR @ (
    PROCEDURE = geometry_contained,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = ~,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.@ (geometry, geometry) OWNER TO mose;

--
-- Name: |&>; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR |&> (
    PROCEDURE = geometry_overabove,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = &<|,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.|&> (geometry, geometry) OWNER TO mose;

--
-- Name: |>>; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR |>> (
    PROCEDURE = geometry_above,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = <<|,
    RESTRICT = positionsel,
    JOIN = positionjoinsel
);


ALTER OPERATOR public.|>> (geometry, geometry) OWNER TO mose;

--
-- Name: ~; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR ~ (
    PROCEDURE = geometry_contain,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = @,
    RESTRICT = contsel,
    JOIN = contjoinsel
);


ALTER OPERATOR public.~ (geometry, geometry) OWNER TO mose;

--
-- Name: ~=; Type: OPERATOR; Schema: public; Owner: mose
--

CREATE OPERATOR ~= (
    PROCEDURE = geometry_same,
    LEFTARG = geometry,
    RIGHTARG = geometry,
    COMMUTATOR = ~=,
    RESTRICT = eqsel,
    JOIN = eqjoinsel
);


ALTER OPERATOR public.~= (geometry, geometry) OWNER TO mose;

--
-- Name: btree_geometry_ops; Type: OPERATOR CLASS; Schema: public; Owner: mose
--

CREATE OPERATOR CLASS btree_geometry_ops
    DEFAULT FOR TYPE geometry USING btree AS
    OPERATOR 1 <(geometry,geometry) ,
    OPERATOR 2 <=(geometry,geometry) ,
    OPERATOR 3 =(geometry,geometry) ,
    OPERATOR 4 >=(geometry,geometry) ,
    OPERATOR 5 >(geometry,geometry) ,
    FUNCTION 1 geometry_cmp(geometry,geometry);


ALTER OPERATOR CLASS public.btree_geometry_ops USING btree OWNER TO mose;

--
-- Name: gist_geometry_ops; Type: OPERATOR CLASS; Schema: public; Owner: mose
--

CREATE OPERATOR CLASS gist_geometry_ops
    DEFAULT FOR TYPE geometry USING gist AS
    STORAGE box2d ,
    OPERATOR 1 <<(geometry,geometry) RECHECK ,
    OPERATOR 2 &<(geometry,geometry) RECHECK ,
    OPERATOR 3 &&(geometry,geometry) RECHECK ,
    OPERATOR 4 &>(geometry,geometry) RECHECK ,
    OPERATOR 5 >>(geometry,geometry) RECHECK ,
    OPERATOR 6 ~=(geometry,geometry) RECHECK ,
    OPERATOR 7 ~(geometry,geometry) RECHECK ,
    OPERATOR 8 @(geometry,geometry) RECHECK ,
    OPERATOR 9 &<|(geometry,geometry) RECHECK ,
    OPERATOR 10 <<|(geometry,geometry) RECHECK ,
    OPERATOR 11 |>>(geometry,geometry) RECHECK ,
    OPERATOR 12 |&>(geometry,geometry) RECHECK ,
    FUNCTION 1 lwgeom_gist_consistent(internal,geometry,integer) ,
    FUNCTION 2 lwgeom_gist_union(bytea,internal) ,
    FUNCTION 3 lwgeom_gist_compress(internal) ,
    FUNCTION 4 lwgeom_gist_decompress(internal) ,
    FUNCTION 5 lwgeom_gist_penalty(internal,internal,internal) ,
    FUNCTION 6 lwgeom_gist_picksplit(internal,internal) ,
    FUNCTION 7 lwgeom_gist_same(box2d,box2d,internal);


ALTER OPERATOR CLASS public.gist_geometry_ops USING gist OWNER TO mose;

SET search_path = pg_catalog;

--
-- Name: CAST (public.box2d AS public.box3d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box2d AS public.box3d) WITH FUNCTION public.box3d(public.box2d) AS IMPLICIT;


--
-- Name: CAST (public.box2d AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box2d AS public.geometry) WITH FUNCTION public.geometry(public.box2d) AS IMPLICIT;


--
-- Name: CAST (public.box3d AS box); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS box) WITH FUNCTION public.box(public.box3d) AS IMPLICIT;


--
-- Name: CAST (public.box3d AS public.box2d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS public.box2d) WITH FUNCTION public.box2d(public.box3d) AS IMPLICIT;


--
-- Name: CAST (public.box3d AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.box3d AS public.geometry) WITH FUNCTION public.geometry(public.box3d) AS IMPLICIT;


--
-- Name: CAST (bytea AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (bytea AS public.geometry) WITH FUNCTION public.geometry(bytea) AS IMPLICIT;


--
-- Name: CAST (public.chip AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.chip AS public.geometry) WITH FUNCTION public.geometry(public.chip) AS IMPLICIT;


--
-- Name: CAST (public.geometry AS box); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS box) WITH FUNCTION public.box(public.geometry) AS IMPLICIT;


--
-- Name: CAST (public.geometry AS public.box2d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS public.box2d) WITH FUNCTION public.box2d(public.geometry) AS IMPLICIT;


--
-- Name: CAST (public.geometry AS public.box3d); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS public.box3d) WITH FUNCTION public.box3d(public.geometry) AS IMPLICIT;


--
-- Name: CAST (public.geometry AS bytea); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS bytea) WITH FUNCTION public.bytea(public.geometry) AS IMPLICIT;


--
-- Name: CAST (public.geometry AS text); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (public.geometry AS text) WITH FUNCTION public.text(public.geometry) AS IMPLICIT;


--
-- Name: CAST (text AS public.geometry); Type: CAST; Schema: pg_catalog; Owner: 
--

CREATE CAST (text AS public.geometry) WITH FUNCTION public.geometry(text) AS IMPLICIT;


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = true;

--
-- Name: conf; Type: TABLE; Schema: public; Owner: mose; Tablespace: 
--

CREATE TABLE conf (
    name character varying(255) NOT NULL,
    value text
);


ALTER TABLE public.conf OWNER TO mose;
CREATE UNIQUE INDEX name ON conf USING btree (name);
ALTER INDEX public.name OWNER TO mose;
--
-- Name: geometry_columns; Type: TABLE; Schema: public; Owner: mose; Tablespace: 
--

CREATE TABLE geometry_columns (
    f_table_catalog character varying(256) NOT NULL,
    f_table_schema character varying(256) NOT NULL,
    f_table_name character varying(256) NOT NULL,
    f_geometry_column character varying(256) NOT NULL,
    coord_dimension integer NOT NULL,
    srid integer NOT NULL,
    "type" character varying(30) NOT NULL
);


ALTER TABLE public.geometry_columns OWNER TO mose;

--
-- Name: spatial_ref_sys; Type: TABLE; Schema: public; Owner: mose; Tablespace: 
--

CREATE TABLE spatial_ref_sys (
    srid integer NOT NULL,
    auth_name character varying(256),
    auth_srid integer,
    srtext character varying(2048),
    proj4text character varying(2048)
);


ALTER TABLE public.spatial_ref_sys OWNER TO mose;

--
-- Name: users; Type: TABLE; Schema: public; Owner: mose; Tablespace: 
--

CREATE TABLE users (
    login character varying(80) NOT NULL,
    pass character(32),
    email character varying(255),
    bio text,
    credential smallint DEFAULT 0 NOT NULL
);


ALTER TABLE public.users OWNER TO mose;

--
-- Name: TABLE users; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON TABLE users IS 'Table des utilisateurs.';


--
-- Name: COLUMN users.login; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON COLUMN users.login IS 'identifiant';


--
-- Name: COLUMN users.pass; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON COLUMN users.pass IS 'mot de passe';


--
-- Name: COLUMN users.email; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON COLUMN users.email IS 'adresse mail';


--
-- Name: COLUMN users.bio; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON COLUMN users.bio IS 'biographie/presentation';


--
-- Name: COLUMN users.credential; Type: COMMENT; Schema: public; Owner: mose
--

COMMENT ON COLUMN users.credential IS '0 si user, 1 si admin';


--
-- Data for Name: conf; Type: TABLE DATA; Schema: public; Owner: mose
--

COPY conf (name, value) FROM stdin;
\.


--
-- Data for Name: geometry_columns; Type: TABLE DATA; Schema: public; Owner: mose
--

COPY geometry_columns (f_table_catalog, f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, "type") FROM stdin;
\.


--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: mose
--

COPY spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: mose
--

COPY users (login, pass, email, bio, credential) FROM stdin;
mose	189cb858653ad61cb4b64587be45b7fd			1
\.


--
-- Name: geometry_columns_pk; Type: CONSTRAINT; Schema: public; Owner: mose; Tablespace: 
--

ALTER TABLE ONLY geometry_columns
    ADD CONSTRAINT geometry_columns_pk PRIMARY KEY (f_table_catalog, f_table_schema, f_table_name, f_geometry_column);


ALTER INDEX public.geometry_columns_pk OWNER TO mose;

--
-- Name: spatial_ref_sys_pkey; Type: CONSTRAINT; Schema: public; Owner: mose; Tablespace: 
--

ALTER TABLE ONLY spatial_ref_sys
    ADD CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid);


ALTER INDEX public.spatial_ref_sys_pkey OWNER TO mose;

--
-- Name: login; Type: INDEX; Schema: public; Owner: mose; Tablespace: 
--

CREATE UNIQUE INDEX login ON users USING btree (login);


ALTER INDEX public.login OWNER TO mose;

--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

