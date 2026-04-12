<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tickets Controller
 *
 * @property \App\Model\Table\TicketsTable $Tickets
 */
class TicketsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
public function index()
{
    $userId = $this->Authentication->getIdentity()->getIdentifier();
    $query = $this->Tickets->find()->where(['user_id' => $userId]);
    if ($this->request->getQuery('search')) {
        $search = $this->request->getQuery('search');
        $query->where([
            'OR' => [
                'subject LIKE' => '%' . $search . '%',
                'customer_name LIKE' => '%' . $search . '%',
            ]
        ]);
    }

    if ($this->request->getQuery('status')) {
        $query->where(['status' => $this->request->getQuery('status')]);
    }

    if ($this->request->getQuery('priority')) {
        $query->where(['priority' => $this->request->getQuery('priority')]);
    }
    $tickets = $this->paginate($query);
    $statsQuery = $this->Tickets->find();
    $stats = $statsQuery
        ->select([
            'status',
            'count' => $statsQuery->func()->count('*')
        ])
        ->where(['user_id' => $userId])
        ->groupBy(['status'])
        ->all();
    $counts = [0 => 0, 1 => 0, 2 => 0]; 
    foreach ($stats as $stat) {
        $counts[$stat->status] = $stat->count;
    }

    $tickets = $this->paginate($query);
    $this->set(compact('tickets', 'counts'));
    // $this->set(compact('tickets'));
}

    /**
     * View method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userId = $this->Authentication->getIdentity()->getIdentifier();
        $ticket = $this->Tickets->find()
            ->where([
                'Tickets.id' => $id,
                'Tickets.user_id' => $userId
            ])
            ->contain(['Notes'])
            ->firstOrFail();
        $this->set(compact('ticket'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ticket = $this->Tickets->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $recaptchaToken = $data['g-recaptcha-response'] ?? '';
            $secretKey = "6LdrsaYsAAAAAC8iPq8fT92Is1cFLXjdq2s06nc_";

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query([
                        'secret' => $secretKey,
                        'response' => $recaptchaToken
                    ]),
                ],
            ];
            $context  = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $responseData = json_decode($response);

            if (!$responseData || !$responseData->success || $responseData->score < 0.5) {
                $this->Flash->error(__('reCAPTCHA verification failed. Please try again.'));
                return $this->redirect($this->referer());
            }
            $data['user_id'] = $this->Authentication->getIdentity()->getIdentifier();

            $ticket = $this->Tickets->patchEntity($ticket, $data);
        $ticket->user_id = $this->Authentication->getIdentity()->getIdentifier();
            if (!$ticket->getErrors()) {
                $attachment = $this->request->getData('attachment_file');
                unset($data['attachment_file']);

                if ($attachment && $attachment instanceof \Psr\Http\Message\UploadedFileInterface && $attachment->getError() === 0) {
                    $name = $attachment->getClientFilename();
                    $newName = time() . '_' . $name;
                    $targetDir = WWW_ROOT . 'uploads' . DS . 'tickets' . DS;
                    $targetPath = $targetDir . $newName;

                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0775, true);
                    }

                    $attachment->moveTo($targetPath);
                    $ticket->attachment = $newName; 
                } else {
                
                    unset($ticket->attachment); 
                }

                if ($this->Tickets->save($ticket)) {
                    $this->Tickets->updateAll(
        ['user_id' => $this->Authentication->getIdentity()->getIdentifier()],
        ['id' => $ticket->id]
    );
                    $this->Flash->success(__('The ticket has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
            }

            $this->Flash->error(__('The ticket could not be saved. Please, try again.'));
        }
        $this->set(compact('ticket'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function edit($id = null)
{
    $ticket = $this->Tickets->get($id); 
    $oldFile = $ticket->attachment;

    if ($this->request->is(['patch', 'post', 'put'])) {
        $data = $this->request->getData();
        $attachment = $this->request->getData('attachment_file');

        $ticket = $this->Tickets->patchEntity($ticket, $data);

        if (!$ticket->getErrors()) {
            if ($attachment && $attachment->getError() === 0) {
                $newName = time() . '_' . $attachment->getClientFilename();
                $targetPath = WWW_ROOT . 'uploads' . DS . 'tickets' . DS . $newName;

                $attachment->moveTo($targetPath);
                $ticket->attachment = $newName;

                if (!empty($oldFile)) {
                    $oldFilePath = WWW_ROOT . 'uploads' . DS . 'tickets' . DS . $oldFile;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); 
                    }
                }
            } else {
                $ticket->attachment = $oldFile;
            }

            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(__('The ticket has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->Flash->error(__('The ticket could not be updated. Please, try again.'));
    }
    $this->set(compact('ticket'));
}
    /**
     * Delete method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticket = $this->Tickets->get($id);
        if ($this->Tickets->delete($ticket)) {
            $this->Flash->success(__('The ticket has been deleted.'));
        } else {
            $this->Flash->error(__('The ticket could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


public function export()
{
    $userId = $this->Authentication->getIdentity()->getIdentifier();
        $tickets = $this->Tickets->find()
        ->where(['user_id' => $userId]) ->order(['created' => 'DESC'])->all();

    $this->response = $this->response->withDownload('my_tickets_' . date('Y-m-d') . '.csv');
    
    $header = ['ID', 'Subject', 'Customer Name', 'Email', 'Priority', 'Status', 'Date Created'];
    
    $stream = fopen('php://temp', 'w');
    
    fprintf($stream, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($stream, $header);

    foreach ($tickets as $ticket) {
        fputcsv($stream, [
            $ticket->id,
            $ticket->subject,
            $ticket->customer_name,
            $ticket->customer_email,
            $ticket->priority === 2 ? 'High' : ($ticket->priority === 1 ? 'Medium' : 'Low'),
            $ticket->getStatusLabel(),
            $ticket->created->format('Y-m-d H:i')
        ]);
    }
    rewind($stream);
    $content = stream_get_contents($stream);fclose($stream);
    $this->response = $this->response->withType('csv')->withStringBody($content);
    return $this->response;
}

public function changeStatus($id = null)
{
    $this->request->allowMethod(['post', 'put']); 
    
    $ticket = $this->Tickets->get($id);
    
    $status = $this->request->getData('status');
    $ticket->status = $status;

    if ($this->Tickets->save($ticket)) {
        $this->Flash->success(__('Status updated successfully.'));
    } else {
        $this->Flash->error(__('Failed to update status. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
}
}
