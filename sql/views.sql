drop view if exists includeplus.vw_active_posts;
create view includeplus.vw_active_posts as
select a.* from includeplus.posts a
left join 
(select b.* from includeplus.removals b where b.approved_by is not null and b.dennied_by is null limit 1) c
on a.id = c.post_id
where a.approved_by is not null and c.approved_by is null and a.dennied_by is null;

drop view if exists includeplus.vw_pending_posts;
create view includeplus.vw_pending_posts as
select a.* from includeplus.posts a
where a.approved_by is null and dennied_by is null;

drop view if exists includeplus.vw_pending_removals;
create view includeplus.vw_pending_removals as
select a.* from includeplus.removals a
where a.approved_by is null and dennied_by is null;

