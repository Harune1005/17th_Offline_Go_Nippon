<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Media;
use App\Models\PostView;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\directoryExists;

class PostController extends Controller
{
    /**
     * 投稿一覧ページ
     */
    public function index()
    {

        $posts = Post::with(['categories', 'user', 'images'])->latest()->get();

        return view('home', compact('posts'));
    }

    /**
     * 投稿作成フォーム
     */
    public function create()
    {
        $all_categories = Category::all();
        $prefectures = Prefecture::all();

        return view('users.posts.create', compact('all_categories', 'prefectures'));
    }

    /**
     * 投稿保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'time_hour' => 'required|integer|min:0|max:23',
            'time_min' => 'required|integer|min:0|max:59',
            'category' => 'required|array|max:3',
            'category.*' => 'nullable|integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'media' => 'required|array|max:3',
            'media.*' => 'required|file|max:204800',
        ]);


        $visitedAt = $validated['date'].' '.
            str_pad($validated['time_hour'], 2, '0', STR_PAD_LEFT).':'.
            str_pad($validated['time_min'], 2, '0', STR_PAD_LEFT).':00';

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'prefecture_id' => $validated['prefecture_id'],
            'visited_at' => $visitedAt,
            'cost' => $validated['cost'] ?? 0,
            'time_hour' => $validated['time_hour'],
            'time_min' => $validated['time_min'],
        ]);

        // category
        if (! empty($validated['category'])) {
            $post->categories()->attach(array_filter($validated['category']));
        }

        // save media
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {

                $mime = $file->getMimeType();

                // in case Image
                if (str_starts_with($mime, 'image')) {
                    $path = $file->store('media/posts', 'public');

                    $post->media()->create([
                        'type'  => 'image',
                        'path'  => $path,
                    ]);
                }
                // in case Video
                elseif(str_starts_with($mime, 'video')){
                    // get duration of video
                    $duration = $this->getVideoDuration($file);

                    if($duration > 30){
                        return redirect()->back()
                            ->withErrors(['media'=>'The video duration must be less than 30 seconds']);
                    }

                    // save video file
                    $path = $file->store('media/posts', 'public');

                    // thumbnail path
                    $thumbPath = 'thumbnails/posts/' . uniqid('thumb_') . '.jpg';

                    // make thumbnail
                    $ok = $this->generateVideoThumbnail($path, $thumbPath);
                    if($ok){
                        $thumbPath = null;
                    }

                    $post->media()->create([
                        'type' => 'video',
                        'path' => $path,
                        'thumbnail_path' => $thumbPath,
                    ]);
                }
            }
        }

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    private function getVideoDuration($file){

        $path = $file->getRealPath();

        // get video information
        $cmd = "ffprobe -v quiet -print_format json -show_format \"$path\"";
        $output = shell_exec($cmd);

        $info = json_decode($output, true);

        return isset($info['format']['duration']) ? floatval($info['format']['duration']): 0;

    }

    private function generateVideoThumbnail($filePath, $thumbnailPath)
    {
        // excute FFmpeg command
        $fullVideoPath = storage_path("app/public/{$filePath}");
        $fullThumbPath = storage_path("app/public/{$thumbnailPath}");
        
        // if there is no directly, make new it
        if (!is_dir(dirname($fullThumbPath))) {
            mkdir(dirname($fullThumbPath), 0777, true);
        }

        // ffmpeg: get the frame at the time 1second passed
        $cmd = "ffmpeg -i {$fullVideoPath} -ss 00:00:01.000 -vframes 1 {$fullThumbPath} -y";

        shell_exec($cmd);

        return file_exists($fullThumbPath);
    }

    /**
     * 投稿詳細
     */
    public function show($id)
    {
        $post = Post::with(['categories', 'user', 'media', 'comments.user'])->findOrFail($id);

        $viewer = Auth::user();

        // Analytics viewer
        if ($viewer) {
            $alreadyViewed = PostView::where('post_id', $post->id)
                ->where('viewer_id', $viewer->id)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if (! $alreadyViewed) {
                PostView::create([
                    'post_id' => $post->id,
                    'viewer_id' => $viewer->id,
                    'is_follower' => $post->user->followers()
                        ->where('follower_id', $viewer->id)
                        ->exists(),
                ]);
            }
        } else {

            PostView::create([
                'post_id' => $post->id,
                'viewer_id' => null,
                'is_follower' => false,
            ]);
        }

        return view('users.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $all_categories = Category::all();
        $prefectures = Prefecture::all();
        $selected_categories = $post->categories->pluck('id')->toArray();

        return view(
            'users.posts.edit',
            compact('post', 'all_categories', 'prefectures', 'selected_categories')
        );
    }

    // --- 更新処理（upload） ---
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time_hour' => 'nullable|integer|min:0|max:23',
            'time_min' => 'nullable|integer|min:0|max:59',
            'category' => 'nullable|array|max:3',
            'category.*' => 'integer|exists:categories,id',
            'prefecture_id' => 'required|integer|exists:prefectures,id',
            'cost' => 'nullable|integer|min:0|max:10000',
            'deleted_media' => 'nullable|array',
            'deleted_media.*' => 'exists:media,id',
            'new_media' => 'nullable|array|max:3',
            'new_media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:204800',
        ]);

        // 1.update basic information

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->prefecture_id = $validated['prefecture_id'];
        $post->cost = $validated['cost'] ?? 0;
        $post->time_hour = $validated['time_hour'];
        $post->time_min = $validated['time_min'];

        if (!empty($validated['date'])) {
            $post->visited_at = sprintf(
                "%s %02d:%02d:00",
                $validated['date'],
                $validated['time_hour'],
                $validated['time_min']
            );
        }

        $post->save();

            // update category
        if (isset($validated['category'])) {
            $post->categories()->sync($validated['category']);
        } else {
            $post->categories()->detach();
        }

        // 2. remove media
        if (!empty($validated['deleted_media'])) {
            $mediaToDelete = Media::whereIn('id', $validated['deleted_media'])
                ->where('post_id', $post->id)
                ->get();

            foreach ($mediaToDelete as $media) {

                // remove main file
                Storage::disk('public')->delete($media->path);

                // if media has thumbnail, remove it
                if($media->thumbnail_path){
                    Storage::disk('public')->delete($media->thumbnail_path);
                }

                $media->delete();
            }
        }

        // count the number of media
        $currentCount = $post->media()->count();

        // the number of new upload media
        $newCount = count($request->file('new_media') ?? []);

        // check the total number of media
        if (($currentCount + $newCount) === 0) {
            return back()
                ->withErrors(['new_media' => 'You must have at least 1 image or video.'])
                ->withInput();
        }
        if ($currentCount + $newCount > 3) {
            return back()->withErrors(['new_media' => 'You can have a maximum of 3 media total (current remaining + new uploads).'])
                ->withInput();
        }

        // 3. new upload
        if ($request->hasFile('new_media')) {
            foreach ($request->file('new_media') as $file) {

                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'image') ? 'image': 'video'; 
                $dir = $type === 'image' ? 'media/posts' : 'media/posts';

                // video duration check 
                if($type === 'video'){
                    $duration = $this->getVideoDuration($file);

                    if ($duration > 30) {

                        return back()->withErrors([
                            'new_media' => 'The video duration must be less than 30seconds',
                        ])->withInput();
                    }
                }

                $path = $file->store($dir, 'public');

                $thumbnailPath = null;

                if($type === 'video'){

                    $thumbnailPath = 'thumbnails/posts/' . uniqid('thumb_') . '.jpg';

                    $ok = $this->generateVideoThumbnail($path, $thumbnailPath);
                    // if you fail to generate thumb nail, leave it null
                    if (! $ok) {
                        $thumbnailPath = null;
                    }
                }

                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                ]);
            }
        }

        return redirect()
            ->route('post.show', $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * 投稿削除
     */
    public function destroy($id)
    {
        $post = Post::with('media')->findOrFail($id);

        if (Auth::id() != $post->user_id) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }

        foreach ($post->media as $media) {
            Storage::disk('public')->delete($media->path);

            if($media->thumbnail_path){
                Storage::disk('public')->delete($media->thumbnail_path);
            }
        }

        $post->media()->delete();

        $post->forceDelete();

        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }
}
