<?php

namespace Admin;

use \View;
use \Request;
use \Input;
use \Auth;
use \Redirect;
use \Validator;

use \Illuminate\Support\Str;
use \Forum;
use \Permission;
use \Topic;
use \Post;
use \Group;

class ForumController extends \BaseController {

	/**
	 * Affiche la page d'index d'administration du forum
	 *
	 */
	public function index()
	{
		$categories = Forum::where('parent_id', '=', 0)->get();

		return View::make('Admin.forum.index', array('categories' => $categories));
	}

	/**
	 * Ajoute une catégorie / un forum
	 *
	 */
	public function add()
	{
		$categories = Forum::where('parent_id', '=', 0)->get();
		$groups = Group::all();
		if(Request::isMethod('post'))
		{
			$parentForum = Forum::find(Input::get('parent_id'));
			$forum = new Forum();
			$forum->name = Input::get('title');
			$forum->position = Input::get('position');
			$forum->slug = Str::slug(Input::get('title'));
			$forum->description = Input::get('description');
			$forum->parent_id = (Input::get('forum_type') == 'category') ? 0 : $parentForum->id;
			$forum->save();

			// Sauvegarde les permission<s></s>
			foreach($groups as $k => $group)
			{
				$perm = Permission::whereRaw('forum_id = ? AND group_id = ?', array($forum->id, $group->id))->first();
				if($perm == null) { $perm = new Permission(); }
				$perm->forum_id = $forum->id;
				$perm->group_id = $group->id;
				if(array_key_exists($group->id, Input::get('permissions')))
				{
					$perm->show_forum = (isset(Input::get('permissions')[$group->id]['show_forum'])) ? true: false;
					$perm->read_topic = (isset(Input::get('permissions')[$group->id]['read_topic'])) ? true: false;
					$perm->reply_topic = (isset(Input::get('permissions')[$group->id]['reply_topic'])) ? true: false;
					$perm->start_topic = (isset(Input::get('permissions')[$group->id]['start_topic'])) ? true: false;
					$perm->upload = (isset(Input::get('permissions')[$group->id]['upload'])) ? true: false;
					$perm->download = (isset(Input::get('permissions')[$group->id]['download'])) ? true: false;
				}
				else
				{
					$perm->show_forum = false;
					$perm->read_topic = false;
					$perm->reply_topic = false;
					$perm->start_topic = false;
					$perm->upload = false;
					$perm->download = false;
				}
				$perm->save();
			}

			return Redirect::route('admin_forum_index');
		}
		return View::make('Admin.forum.add', array('categories' => $categories, 'groups' => $groups));
	}

	/**
	 * Edite le forum
	 *
	 *
	 */
	public function edit($slug, $id)
	{
		$categories = Forum::where('parent_id', '=', 0)->get();
		$groups = Group::all();
		$forum = Forum::find($id);
		if(Request::isMethod('post'))
		{
			$forum->name = Input::get('title');
			$forum->position = Input::get('position');
			$forum->slug = Str::slug(Input::get('title'));
			$forum->description = Input::get('description');
			//$forum->parent_id = (Input::get('forum_type') == 'category') ? 0 : Input::get('parent_id'); // Non changé depuis la création
			$forum->parent_id = Input::get('parent_id');
			$forum->save();

			// Sauvegarde des permissions dans la DB
			// Sauvegarde les permission<s></s>
			foreach($groups as $k => $group)
			{
				$perm = Permission::whereRaw('forum_id = ? AND group_id = ?', array($forum->id, $group->id))->first();
				if($perm == null) { $perm = new Permission(); }
				$perm->forum_id = $forum->id;
				$perm->group_id = $group->id;
				if(array_key_exists($group->id, Input::get('permissions')))
				{
					$perm->show_forum = (isset(Input::get('permissions')[$group->id]['show_forum'])) ? true: false;
					$perm->read_topic = (isset(Input::get('permissions')[$group->id]['read_topic'])) ? true: false;
					$perm->reply_topic = (isset(Input::get('permissions')[$group->id]['reply_topic'])) ? true: false;
					$perm->start_topic = (isset(Input::get('permissions')[$group->id]['start_topic'])) ? true: false;
					$perm->upload = (isset(Input::get('permissions')[$group->id]['upload'])) ? true: false;
					$perm->download = (isset(Input::get('permissions')[$group->id]['download'])) ? true: false;
				}
				else
				{
					$perm->show_forum = false;
					$perm->read_topic = false;
					$perm->reply_topic = false;
					$perm->start_topic = false;
					$perm->upload = false;
					$perm->download = false;
				}
				$perm->save();
			}

			return Redirect::route('admin_forum_index');
		}
		return View::make('Admin.forum.edit', array('categories' => $categories, 'groups' => $groups, 'forum' => $forum));
	}

	/**
	 * Supprime un forum / une catégorie ainsi que les topics et sous-forums
	 *
	 *
	 */
	public function delete($slug, $id)
	{
		// Forum to delete
		$forum = Forum::find($id);

		$permissions = Permission::where('forum_id', '=', $forum->id)->get();
		foreach($permissions as $p)
		{
			$p->delete();
		}
		unset($permissions);

		if($forum->parent_id == 0)
		{
			$category = $forum;
			$permissions = Permission::where('forum_id', '=', $category->id)->get();
			foreach($permissions as $p)
			{
				$p->delete();
			}

			$forums = $category->getForumsInCategory();
			foreach($forums as $forum)
			{
				$permissions = Permission::where('forum_id', '=', $forum->id)->get();
				foreach($permissions as $p)
				{
					$p->delete();
				}

				foreach($forum->topics as $t)
				{
					foreach($t->posts as $p)
					{
						$p->delete();
					}
					$t->delete();
				}
				$forum->delete();
			}
			$category->delete();
		}
		else
		{
			$permissions = Permission::where('forum_id', '=', $forum->id)->get();
			foreach($permissions as $p)
			{
				$p->delete();
			}
			foreach($forum->topics as $t)
			{
				foreach($t->posts as $p)
				{
					$p->delete();
				}
				$t->delete();
			}
			$forum->delete();
		}
		return Redirect::route('admin_forum_index');
	}
} ?>
