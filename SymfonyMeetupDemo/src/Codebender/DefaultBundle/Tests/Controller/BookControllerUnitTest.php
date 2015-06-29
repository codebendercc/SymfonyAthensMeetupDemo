<?php

namespace Codebender\DefaultBundle\Tests\Controller;

class BookControllerUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testIndexActionNoDatabase() {

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
        
    }
}