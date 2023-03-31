<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\Exercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        //BLOC CREATION JOB

        $job1 = new Job();
        $job1->setName("CEO");
        $job1->setIntern(true);
        $manager->persist($job1);

        $job2 = new Job();
        $job2->setName("Responsable contenu");
        $job2->setIntern(true);
        $manager->persist($job2);

        $job3 = new Job();
        $job3->setName("Responsable RH");
        $job3->setIntern(true);
        $manager->persist($job3);

        $job4 = new Job();
        $job4->setName("Clown");
        $job4->setIntern(false);
        $manager->persist($job4);

        $job5 = new Job();
        $job5->setName("Buraliste");
        $job5->setIntern(false);
        $manager->persist($job5);

        $job6 = new Job();
        $job6->setName("Equipier polyvalent");
        $job6->setIntern(false);
        $manager->persist($job6);

        //BLOC CREATION TAG
        $tag1 = new Tag();
        $tag1->setName("Maternité");
        $manager->persist($tag1);

        $tag2 = new Tag();
        $tag2->setName("Musculation");
        $manager->persist($tag2);

        $tag3 = new Tag();
        $tag3->setName("Dentiste");
        $manager->persist($tag3);

        $tag4 = new Tag();
        $tag4->setName("Cardio");
        $manager->persist($tag4);

        $tag5 = new Tag();
        $tag5->setName("Maladie chronique");
        $manager->persist($tag5);

        $tag6 = new Tag();
        $tag6->setName("Etirement");
        $manager->persist($tag6);

        $tag7 = new Tag();
        $tag7->setName("Echauffement");
        $manager->persist($tag7);

        $tag8 = new Tag();
        $tag8->setName("Opthalmologie");
        $manager->persist($tag8);

        $tag9 = new Tag();
        $tag9->setName("Podologie");
        $manager->persist($tag9);
        
        //BLOC CREATION USER
        $user1 = new User();
        $user1->setEmail('mail1@mail.com');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setLastname('Bin');
        $user1->setFirstname('Chilling');
        $user1->setJob($job1);
        $user1->setSocialSecurityNumber("197153638292736383");
        $user1->setSex('male');
        $user1->setBirthdate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s','1997-10-28 00:00:00'));
        $user1->setPhonenumber('0101010101');
        $user1->setDoctor('Mahbul');
        $user1->setSize(173);
        $user1->setWeight(66);
        $user1->setPassword("1234567");
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('mail2@mail.com');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setLastname('Jean');
        $user2->setFirstname('Bon');
        $user2->setJob($job2);
        $user2->setSocialSecurityNumber("1971536876674568");
        $user2->setSex('male');
        $user2->setBirthdate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s','1983-07-29 00:00:00'));
        $user2->setPhonenumber('0145230101');
        $user2->setDoctor('Strange');
        $user2->setSize(180);
        $user2->setWeight(77);
        $user2->setPassword("1234567");
        $manager->persist($user2);

        $user = new User();
        $user->setEmail('mail3@mail.com');
        $user->setLastname('Ben');
        $user->setFirstname('Laden');
        $user->setJob($job4);
        $user->setSocialSecurityNumber("1971786764343456789");
        $user->setSex('male');
        $user->setBirthdate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s','1983-06-03 00:00:00'));
        $user->setPhonenumber('0146780101');
        $user->setDoctor('Who');
        $user->setSize(168);
        $user->setWeight(59);
        $user->setPassword("1234567");

        $user = new User();
        $user->setEmail('mail4@mail.com');
        $user->setLastname('Pierre');
        $user->setFirstname('Jack');
        $user->setJob($job5);
        $user->setSocialSecurityNumber("1971786987654");
        $user->setSex('male');
        $user->setBirthdate(DateTimeImmutable::createFromFormat('Y-m-d H:i:s','1968-04-10 00:00:00'));
        $user->setPhonenumber('0146780101');
        $user->setDoctor('Gynéco');
        $user->setSize(198);
        $user->setWeight(113);
        $user->setPassword("1234567");
        $manager->persist($user);

        //BLOC POUR POST
        $post = new Post();
        $post->setTitle('SOYEZ REMBOURSÉ');
        $post->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus. Praesent viverra urna quis faucibus viverra. Nam egestas mi eu augue fermentum, id ultricies nulla feugiat. Aenean suscipit fermentum ipsum, eget varius enim convallis id. Maecenas ornare arcu eu efficitur iaculis. Proin sed elit id lectus pellentesque convallis. Suspendisse eget elit in nisl hendrerit sodales. Nullam vel magna bibendum, semper sapien et, pharetra turpis. Aenean sodales turpis quis metus pharetra, volutpat vehicula arcu euismod. Mauris molestie facilisis arcu ut fermentum.");
        $post->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
        $post->setAuthor($user2);
        $post->setImage('image_flemme1.jpeg');
        $post->addTag($tag1);
        $post->addTag($tag5);
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('SOIGNEZ VOS DENTS');
        $post->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus. Praesent viverra urna quis faucibus viverra. Nam egestas mi eu augue fermentum, id ultricies nulla feugiat. Aenean suscipit fermentum ipsum, eget varius enim convallis id. Maecenas ornare arcu eu efficitur iaculis. Proin sed elit id lectus pellentesque convallis. Suspendisse eget elit in nisl hendrerit sodales. Nullam vel magna bibendum, semper sapien et, pharetra turpis. Aenean sodales turpis quis metus pharetra, volutpat vehicula arcu euismod. Mauris molestie facilisis arcu ut fermentum.");
        $post->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
        $post->setAuthor($user2);
        $post->setImage('image_flemme2.jpeg');
        $post->addTag($tag3);
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('SOIGNEZ VOS YEUX');
        $post->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus. Praesent viverra urna quis faucibus viverra. Nam egestas mi eu augue fermentum, id ultricies nulla feugiat. Aenean suscipit fermentum ipsum, eget varius enim convallis id. Maecenas ornare arcu eu efficitur iaculis. Proin sed elit id lectus pellentesque convallis. Suspendisse eget elit in nisl hendrerit sodales. Nullam vel magna bibendum, semper sapien et, pharetra turpis. Aenean sodales turpis quis metus pharetra, volutpat vehicula arcu euismod. Mauris molestie facilisis arcu ut fermentum.");
        $post->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
        $post->setAuthor($user2);
        $post->setImage('image_flemme3.jpeg');
        $post->addTag($tag8);
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('SOIGNEZ VOS PIEDS');
        $post->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus. Praesent viverra urna quis faucibus viverra. Nam egestas mi eu augue fermentum, id ultricies nulla feugiat. Aenean suscipit fermentum ipsum, eget varius enim convallis id. Maecenas ornare arcu eu efficitur iaculis. Proin sed elit id lectus pellentesque convallis. Suspendisse eget elit in nisl hendrerit sodales. Nullam vel magna bibendum, semper sapien et, pharetra turpis. Aenean sodales turpis quis metus pharetra, volutpat vehicula arcu euismod. Mauris molestie facilisis arcu ut fermentum.");
        $post->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
        $post->setAuthor($user2);
        $post->setImage('image_flemme4.jpeg');
        $post->addTag($tag9);
        $manager->persist($post);

        //BLOC CREATION EXERCICE
        $exo1 = new Exercice();
        $exo1->setName('Pompes');
        $exo1->setDuration('300');
        $exo1->setEquipment("Un beau corps");
        $exo1->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus.");
        $exo1->setUrlyoutube("lSJTS87Ab4w");
        $exo1->setCover('image_flemme1.jpeg');
        $exo1->addTag($tag2);
        $exo1->setAuthor($user2);
        $manager->persist($exo1);

        $exo2 = new Exercice();
        $exo2->setName('Tractions');
        $exo2->setDuration('300');
        $exo2->setEquipment("Des beaux bras");
        $exo2->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus.");
        $exo2->setUrlyoutube("lSJTS87Ab4w");
        $exo2->setCover('image_flemme2.jpeg');
        $exo2->addTag($tag2);
        $exo2->setAuthor($user2);
        $manager->persist($exo2);

        $exo3 = new Exercice();
        $exo3->setName('Burpees');
        $exo3->setDuration(180);
        $exo3->setEquipment("Un beau cul");
        $exo3->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis rutrum eros, sit amet dignissim sem luctus sed. Nam non tempor arcu. Aenean tellus magna, tempor id ipsum eu, volutpat laoreet ipsum. Maecenas placerat convallis turpis, ut dignissim lectus elementum in. Vivamus euismod, turpis et iaculis ultrices, mauris ipsum faucibus est, in cursus odio arcu eu lacus. Donec pharetra nisl sit amet sapien tristique bibendum. Phasellus volutpat condimentum faucibus. Maecenas nec tellus vel lectus pellentesque tristique. Mauris varius lacus non sollicitudin finibus.");
        $exo3->setUrlyoutube("lSJTS87Ab4w");
        $exo3->setCover('image_flemme3.jpeg');
        $exo3->addTag($tag4);
        $exo3->setAuthor($user2);
        $manager->persist($exo3);


        $manager->flush();

    }

}