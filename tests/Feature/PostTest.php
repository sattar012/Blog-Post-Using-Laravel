<?php

namespace Tests\Feature;

use App\Models\BlogPost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Tests\TestCase;
use App\Models\Comment;

class PostTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBLogsWhenNothingInDatabase()
    {
       $response = $this->get('/posts');

       $response->assertSeeText('No posts found!');
    }

    public function testSee1BlogpostWhenThreis1comments()
    {
        $post = $this->createDummyBlogPost();

        //Act

        $response = $this->get('/posts');

        //Assert

        $response ->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts',[
            'title'=>'New title'
        ]);


    }
    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }


    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content'=>'at least 10 caharcters',
        ];

        $this->post('/posts',$params)
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertEquals(session('status'),'The Blog post is create!');
    }


    public function testStoreFail()

    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');


    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts',[
            'title'=>'New title',
            
        ]);

        $params = [
            'title' => 'a new named title',
            'content' => 'Content was changed'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog Post was updated');
        $this->assertDatabaseMissing('blog_posts',$post->toArray());
        $this->assertDatabaseHas('blog_posts',[

            'title'=>'a new named title'
        ]);
    }

    public function testDelete()
        {
            $post=$this->createDummyBlogPost();
            $this->assertDatabaseHas('blog_posts', [
                'title' => 'New title',
                
            ]);


            $this->delete("/posts/{$post->id}" )
                ->assertStatus(302)
                ->assertSessionHas('status');

            $this->assertEquals(session('status'),'Blog post was Deleted');
            $this->assertDatabaseMissing('blog_posts',$post->toArray());


        }


        public function createDummyBlogPost()
        {
            $post = BlogPost::factory()->newTitle()->create();
     
            return $post;
     
        }






    }

    

