import { ComponentFixture, TestBed } from '@angular/core/testing';
import { LayerOptionsComponent } from './layer-options.component';

describe('LayerOptionsComponent', () => {
  let component: LayerOptionsComponent;
  let fixture: ComponentFixture<LayerOptionsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LayerOptionsComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(LayerOptionsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
