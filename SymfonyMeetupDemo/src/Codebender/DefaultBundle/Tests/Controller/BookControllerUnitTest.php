<?php

namespace Codebender\DefaultBundle\Tests\Controller;

class BookControllerUnitTest extends \PHPUnit_Framework_TestCase
{
    private function setupController(&$bookController, &$doctrineRegistry, &$entityManager) {
        $bookController = $this->getMockBuilder('Codebender\DefaultBundle\Controller\BookController')
            ->disableOriginalConstructor()
            ->setMethods(array('getDoctrine'))
            ->getMock();

        $doctrineRegistry = $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->setMethods(array('getManager'))
            ->getMock();

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getRepository'))
            ->getMock();
    }
    /**
     * @expectedException \Exception
     */
    public function testIndexActionNoDatabase() {

        $this->setupController($bookController, $doctrineRegistry, $entityManager);

        $bookRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->getMock();

        $bookController->expects($this->once())->method('getDoctrine')
            ->will($this->returnValue($doctrineRegistry));
        
        $doctrineRegistry->expects($this->once())->method('getManager')
            ->will($this->returnValue($entityManager));
        
        $entityManager->expects($this->once())->method('getRepository')
            ->with('CodebenderDefaultBundle:Book')
            ->will($this->returnValue($bookRepository));
        
        $bookRepository->method('findAll')
            ->will($this->throwException(new \Exception));;

        $result = $bookController->indexAction();
        
        $this->assertEquals(array('entities' => array()), $result);
    }

    public function testIndexActionNormalExecution() {

        $this->setupController($bookController, $doctrineRegistry, $entityManager);
        
        $bookRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('findAll'))
            ->getMock();

        $bookController->expects($this->once())->method('getDoctrine')
            ->will($this->returnValue($doctrineRegistry));

        $doctrineRegistry->expects($this->once())->method('getManager')
            ->will($this->returnValue($entityManager));

        $entityManager->expects($this->once())->method('getRepository')
            ->with('CodebenderDefaultBundle:Book')
            ->will($this->returnValue($bookRepository));

        $bookRepository->expects($this->once())->method('findAll')
            ->will($this->returnValue(array('entities & objects')));

        $result = $bookController->indexAction();

        $this->assertEquals(array('entities' => array('entities & objects')), $result);
    }
}